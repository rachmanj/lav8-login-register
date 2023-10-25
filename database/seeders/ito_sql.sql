--Query Inventory Transfer
/* SELECT FROM [dbo].[OWTR] T0*/
DECLARE @A AS DATETIME
DECLARE @B AS DATETIME
/* WHERE */
SET @A = /* T0.DocDate 'FromDate'  */ '[%0]'
SET @B = /* T0.DocDate 'ToDate' */ '[%1]'

SELECT DISTINCT
T10.[DocNum] 'grpo_no', 
T10.[CreateDate] 'grpo_date',
T0.[DocNum] 'ito_no', 
--T0.[U_MIS_TransferType],
T0.[DocDate] 'ito_date', 
T0.[CreateDate] 'ito_created_date',
--T0.[Printed],
--T3.[DocNum] 'ITI No',
--T3.[DocDate] 'ITI Date',
--T3.[CreateDate] 'ITI Created Date',
--T1.[ItemCode], T1.[Dscription],
--T1.[unitMsr] 'UoM', 
--T1.[Quantity] 'Qty', 
--T2.[AvgPrice] 'Item Cost (USD)',
--T1.[Quantity]*T2.[AvgPrice] as 'Total',
--T4.[DocNum] 'GRPO No',
T6.[DocNum] 'po_no',
--T7.[DocNum] 'PR No',
--T9.[DocNum] 'MR No',
--T7.[U_MIS_UnitNo] 'Unit No',
--T7.[U_MIS_ModeNo] 'Unit Model',
--T4.[CardName] 'Vendor', 
T0.[Filler] 'from_warehouse', 
T0.[U_MIS_ToWarehouse] 'to_warehouse',
--T0.[U_MIS_TransferType] 'TransferType', T0.[Comments],
--CASE T0.[U_ARK_DelivStat] WHEN 'N' THEN 'Not Delivered' WHEN 'Y' THEN 'Delivered' END 'Delivery Status',
T0.[U_MIS_DeliveryTime] 'delivery_date',
T0.Comments 'Remarks'

FROM 
OWTR T0 
INNER JOIN WTR1 T1 ON T0.[DocEntry] = T1.[DocEntry]
INNER JOIN OITW T2 ON T1.[ItemCode] = T2.[ItemCode]
LEFT JOIN OWTR T3 ON T0.DocNum = T3.U_MIS_DocRefNo
LEFT JOIN OPDN T4 ON T0.U_MIS_GRPONo = T4.DocNum
LEFT JOIN PDN1 T5 ON T4.DocEntry = T5.DocEntry
LEFT JOIN OPOR T6 ON T5.BaseRef = T6.DocNum
LEFT JOIN OPRQ T7 ON T6.U_MIS_PRNo = T7.DocNum
LEFT JOIN POR1 T8 ON T6.DocEntry = T8.DocEntry
LEFT JOIN ORDR T9 ON T8.U_MISMRNo = T9.DocNum
LEFT JOIN OPDN T10 ON T0.U_MIS_GRPONo = T10.DocNum

WHERE T0.[DocDate] >= @A AND T0.[DocDate] <= @B AND T2.[WhsCode] = T0.[Filler] AND T0.[U_MIS_TransferType] = 'OUT'
ORDER BY T0.[DocNum] ASC

FOR BROWSE