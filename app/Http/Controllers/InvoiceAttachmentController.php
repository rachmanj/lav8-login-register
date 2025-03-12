<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InvoiceAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($invoiceId)
    {
        try {
            $invoice = Invoice::with('attachments')->findOrFail($invoiceId);
            return response()->json([
                'success' => true,
                'data' => $invoice->attachments
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading attachments: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $invoice
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $invoice)
    {
        $request->validate([
            'attachment' => 'required|file|max:10240', // 10MB max
            'description' => 'nullable|string|max:255',
        ]);

        $invoiceId = $invoice;
        $invoice = Invoice::findOrFail($invoiceId);
        
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $originalName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            $fileType = $file->getMimeType();
            
            // Generate a unique filename
            $filename = Str::random(20) . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Store the file
            $path = $file->storeAs('invoice_attachments/' . $invoiceId, $filename, 'public');
            
            // Create attachment record
            $attachment = new InvoiceAttachment();
            $attachment->inv_id = $invoiceId;
            $attachment->filename = $originalName;
            $attachment->filepath = $path;
            $attachment->filetype = $fileType;
            $attachment->filesize = $fileSize;
            $attachment->description = $request->description;
            $attachment->uploaded_by = Auth::user()->name ?? 'System';
            $attachment->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Attachment uploaded successfully',
                'data' => $attachment
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'No file uploaded'
        ], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $attachment = InvoiceAttachment::findOrFail($id);
        
        if (!Storage::disk('public')->exists($attachment->filepath)) {
            return response()->json([
                'success' => false,
                'message' => 'File not found'
            ], 404);
        }
        
        $filePath = storage_path('app/public/' . $attachment->filepath);
        
        // Check if this is a view or download request
        $isViewRequest = $request->has('view');
        $isDownloadRequest = $request->has('download');
        
        // Get file mime type
        $mimeType = Storage::disk('public')->mimeType($attachment->filepath);
        
        // If it's a view request, stream the file with Content-Disposition: inline
        if ($isViewRequest) {
            return response()->file($filePath, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $attachment->filename . '"'
            ]);
        }
        
        // Otherwise, force download
        return response()->download($filePath, $attachment->filename);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string|max:255',
        ]);
        
        $attachment = InvoiceAttachment::findOrFail($id);
        $attachment->description = $request->description;
        $attachment->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Attachment updated successfully',
            'data' => $attachment
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attachment = InvoiceAttachment::findOrFail($id);
        
        // Delete the file from storage
        if (Storage::disk('public')->exists($attachment->filepath)) {
            Storage::disk('public')->delete($attachment->filepath);
        }
        
        // Delete the record
        $attachment->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Attachment deleted successfully'
        ]);
    }
}
