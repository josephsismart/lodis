<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
defined('BASEPATH') OR exit('No direct script access allowed');

class Getdata extends MY_Controller
{
    public function __construct(){
      parent::__construct();
        $this->redirect();
        $this->load->model('mainModel');
        $this->load->helper('date');
        date_default_timezone_set("Asia/Manila");
    }

    function getVariantCategory(){
        $data = ["data" => []];
        $dataTemp = [];
        $user_id = $this->session->schoolmis_login_id;

        $thisQuery=$this->db->query("SELECT * FROM view_itemtype");
        
        $cc=1;
        foreach ($thisQuery->result() as $key => $value) {
            $id = $value->id;
         
            $data2 = [
                "typeId" => $value->id,
                "itemType" => $value->itemGroupId,
                "description" => $value->itemTypeName,
            ];
            $arr = json_encode($data2);
            $data["data"][] = [
                $cc++,
                "<div class='row'><div class='col-6'><span class='badge bg-gradient-success text-md'>$value->itemTypeName</span><br/>
                    <span class='badge mt-1'>$value->description</span>
                </div>
                <div class='col-6'>
                    <button type='button' class='btn btn-xs text-sm float-right text-gray' data-toggle='dropdown' aria-expanded='true'>
                        <span class='fa fa-ellipsis-h'></span>
                    </button>
                    <div class='dropdown-menu'>
                        <a class='dropdown-item' href='#' onclick='getDetails(\"VariantCategory\",$arr,1)'>Edit Information</a>
                    </div>
                </div></div>",
            ];
        }
        echo json_encode($data);
    }

    function getMemberUser(){
        $data = ["data" => []];
        $dataTemp = [];
        $user_id = $this->session->schoolmis_login_id;

        $thisQuery=$this->db->query("SELECT t1.id,t1.partyId,t1.firstName,t1.middleName,
                                    t1.lastName,t1.nameExt,t1.sex,t1.address,t1.description,
                                    t1.fullName,t1.sex FROM view_person t1");
        $cc=1;
        foreach ($thisQuery->result() as $key => $value) {
            $id = $value->id;
            $data2 = [
                "personId" => $id,
                "partyType" => $value->partyId,
                "firstName" => $value->firstName,
                "middleName" => $value->middleName,
                "lastName" => $value->lastName,
                "extName" => $value->nameExt,
                "sex" => $value->sex,
                "homeAddress" => $value->address,
            ];
            $arr = json_encode($data2);
            $data["data"][] = [
                $cc++,
                $value->description,
                "<div class='row'><div class='col-6'><span class='badge bg-gradient-navy text-md'>$value->fullName</span>
                    <span class='badge bg-".($value->sex==1?"blue":"pink")."'>".($value->sex==1?"MALE":"FEMALE")."</span><br/>
                    <span class='badge bg-gradient-success mt-1'>".$value->address."</span>
                </div>
                <div class='col-6'>
                    <button type='button' class='btn btn-xs text-sm float-right text-gray' data-toggle='dropdown' aria-expanded='true'>
                        <span class='fa fa-ellipsis-h'></span>
                    </button>
                    <div class='dropdown-menu'>
                        <a class='dropdown-item' href='#' onclick='getDetails(\"MemberUser\",$arr,1)'>Edit Information</a>
                    </div>
                </div></div>",
            ];
        }
        echo json_encode($data);
    }

    function getInventoryItem(){
        $data = ["data" => []];
        $dataTemp = [];
        $user_id = $this->session->schoolmis_login_id;

        $thisQuery=$this->db->query("SELECT * FROM view_inventory");
        
        $cc=1;
        foreach ($thisQuery->result() as $key => $value) {
            $id = $value->id;
            $dateTrans = date_create($value->dateTrans);
            $datePurchase = date_create($value->purchaseDate);
            $totalCount = number_format($value->totalCount);
            $totalWeight = number_format($value->totalWeight);
            $totalSacks = number_format($value->totalSacks);
            $totalDeduction = number_format($value->totalDeduction);
            $totalKilo = number_format($value->totalKilo);
            $price = number_format($value->price);
            $data2 = [
                "inventId" => $value->id,
                "personId" => $value->personId,
                "varietyId" => $value->varietyId,
                "transactDate" => $value->dateTrans,
            ];
            $data3 = [
                "inventoryId" => $value->id,
                "fullName" => $value->fullName,
                "variety" => $value->variantName,
                "transDate" => date_format($dateTrans,"M d, Y"),
                "totalCount" => $value->totalCount,
                "totalWeight" => $value->totalWeight,
                "totalSacks" => $value->totalSacks,
            ];
            $data4 = [
                "purchaseOrderCode" => $value->purchaseOrderCode,
                "stockCode" => "-",
                "inventoryId" => $value->id,
                "fullName" => $value->fullName,
                "variety" => $value->variantName,
                "transDate" => date_format($dateTrans,"M d, Y"),
                "totalCount" => $value->totalCount,
                "totalWeight" => $value->totalWeight,
                "totalSacks" => $value->totalSacks,

                "poId" => $value->pOrderId,
                "purchaseDate" => $value->purchaseDate,//date_format($datePurchase,"M d, Y"),
                "totalDeduct" => $value->totalDeduction,
                "totalKilo" => $value->totalKilo,
                "price" => $value->price,
            ];
            $arr2 = json_encode($data2);
            $arr3 = json_encode($data3);
            $arr4 = json_encode($data4);            
            $data["data"][] = [
                $cc++,
                "<span class='badge bg-gray mb-2' title='Inventory Code'>$value->inventoryCode</span><br/>".
                "<span title='Member' class='badge bg-gradient-success text-md mb-1'>$value->fullName</span><br/>".
                "<span class='badge bg-primary text-sm' title='Variety'>$value->variantName</span> ".
                "<span class='badge bg-gradient-info text-sm' title='Transaction Date'><i class='fa fa-calendar'></i> $value->dateTrans</span>".
                "<button type='button' class='btn btn-xs text-sm text-gray' data-toggle='dropdown' aria-expanded='true'><span class='fa fa-ellipsis-h'></span></button>
                <div class='dropdown-menu'>
                    <a class='dropdown-item' href='#' onclick='getDetails(\"InventoryItem\",$arr2,1)'>Edit Inventory Details</a>
                    <a class='dropdown-item' href='#' onclick='createInvent($arr3)'>Add Inventory Items</a>".
                    ($value->totalCount && !$value->totalDeduction?"<div class='dropdown-divider'></div>
                    <a class='dropdown-item' href='#' onclick='getDetails(\"PurchaseOrder\",$arr3,0)' data-toggle='modal' data-target='#modalPurchaseOrder'>Purchase Order</a>":null).
                    // ($value->totalDeduction?"<div class='dropdown-divider'></div>
                    // <a class='dropdown-item' href='#'>Edit Purchase Order</a>":null).
                "</div>".
                ($value->totalCount?
                    "<br/><span class='badge bg-info mt-2 text-sm' title='Total Item'>Total items: <b> $totalCount</b></span> ".
                    "<span class='badge bg-navy text-sm' title='Total Weight'><i class='fa fa-tachometer-alt'></i>  $totalWeight</span> ".
                    "<span class='badge bg-navy text-sm' title='Total Sacks'><i class='fa fa-shopping-bag'></i>  $totalSacks</span><br/>"
                :"-"),
                ($value->inventoryIdPO?
                    "<span class='badge bg-purple mb-2' title='Purchase Order Code'>$value->purchaseOrderCode</span><br/>".
                    "<span class='badge bg-red text-sm mb-1' title='Total Deduction'>Deduction: $totalDeduction</span><br/>".
                    "<span class='badge bg-info text-sm mb-1' title='Purchase Date'><i class='fa fa-calendar'></i> $value->purchaseDate</span>".
                    (!$value->stockPOId?"<button type='button' class='btn btn-xs text-sm text-gray' data-toggle='dropdown' aria-expanded='true'><span class='fa fa-ellipsis-h'></span></button>
                    <div class='dropdown-menu'>
                        <a class='dropdown-item' href='#' onclick='getDetails(\"PurchaseOrder\",$arr4,1)' data-toggle='modal' data-target='#modalPurchaseOrder'>Edit Purchase Order Details</a>
                        <a class='dropdown-item' href='#' onclick='getDetails(\"Stock\",$arr4,0)' data-toggle='modal' data-target='#modalStock'>Add to Stock</a>".
                        // ($value->totalCount && !$value->totalDeduction?"<div class='dropdown-divider'></div>
                        // <a class='dropdown-item' href='#' onclick='getDetails(\"PurchaseOrder\",$arr3,0)' data-toggle='modal' data-target='#modalPurchaseOrder'>Purchase Order</a>":null).
                        // ($value->totalDeduction?"<div class='dropdown-divider'></div>
                        // <a class='dropdown-item' href='#'>Edit Purchase Order</a>":null).
                    "</div>":null).
                    "<br/><span class='badge bg-navy text-sm mt-2' title='Total Kilo'><i class='fa fa-tachometer-alt'></i> $totalKilo</span> ".
                    "<span class='badge bg-navy text-sm mt-2' title='Price'><i class='fa fa-money-bill-alt'></i> $price</span><br/>"
                :"-"),
            ];
        }
        echo json_encode($data);
    }

    function getStockPurchaseRequest(){
        $data = ["data" => []];
        $dataTemp = [];
        $user_id = $this->session->schoolmis_login_id;
        $thisQuery=$this->db->query("SELECT
                                    t2.dateTrans,
                                    t2.fullName,
                                    t2.variantName,
                                    t2.totalCount,
                                    t2.totalWeight,
                                    t2.totalSacks,
                                    t2.pOrderId,
                                    t2.purchaseDate,
                                    t2.totalDeduction,
                                    t2.totalKilo,
                                    t2.price, t1.* FROM view_stock t1
                                    LEFT JOIN view_inventory t2 on t1.purchaseOrderId = t2.pOrderId");
        
        $cc=1;
        foreach ($thisQuery->result() as $key => $value) {
            $dateTrans = date_create($value->dateTrans);
            $pRequestNumKilos = number_format($value->pRequestNumKilos);
            $pRequestPrice = number_format($value->pRequestPrice);
            $stockKilos = number_format($value->stockKilos);
            $stockSacks = number_format($value->stockSacks);
            
            $data1 = [
                "purchaseOrderCode" => $value->purchaseOrderCode,
                "stockCode" => $value->stockCode,
                "fullName" => $value->fullName,
                "variety" => $value->variantName,
                "transDate" => date_format($dateTrans,"M d, Y"),
                "totalCount" => $value->totalCount,
                "totalWeight" => $value->totalWeight,
                "totalSacks" => $value->totalSacks,

                "poId" => $value->pOrderId,
                "stockId" => $value->stockId,
                "purchaseDate" => $value->purchaseDate,//date_format($datePurchase,"M d, Y"),
                "totalDeduct" => $value->totalDeduction,
                "totalKilo" => $value->totalKilo,
                "price" => $value->price,

                "stockDate" => $value->date_stock,
                "noOfSacks" => $value->stockSacks,
                "noOfKilo" => $value->stockKilos,
            ];
            $arr1 = json_encode($data1);
            $data["data"][] = [
                $cc++,
                "<span class='badge bg-yellow mb-1' title='Stock Code'>$value->stockCode</span> ".
                "<span class='badge bg-purple mb-1' title='Purchase Order Code'>$value->purchaseOrderCode</span><br/>". 
                "<span class='badge bg-gradient-info text-sm mt-1' title='Stock Date'><i class='fa fa-calendar'></i> $value->date_stock</span> ".
                (!$value->prstockId?"<button type='button' class='btn btn-xs text-sm text-gray' data-toggle='dropdown' aria-expanded='true'><span class='fa fa-ellipsis-h'></span></button>
                <div class='dropdown-menu'>
                    <a class='dropdown-item' href='#' onclick='getDetails(\"Stock\",$arr1,1)' data-toggle='modal' data-target='#modalStock'>Edit Stock Details</a>
                    <a class='dropdown-item' href='#' onclick='getDetails(\"PurchaseRequest\",$arr1,0)' data-toggle='modal' data-target='#modalPurchaseRequest'>Create Purchase Request</a>".
                    // ($value->totalCount && !$value->totalDeduction?"<div class='dropdown-divider'></div>
                    // <a class='dropdown-item' href='#' onclick='getDetails(\"PurchaseOrder\",$arr3,0)' data-toggle='modal' data-target='#modalPurchaseOrder'>Purchase Order</a>":null).
                    // ($value->totalDeduction?"<div class='dropdown-divider'></div>
                    // <a class='dropdown-item' href='#'>Edit Purchase Order</a>":null).
                "</div>":null).
                "<br/><span class='badge bg-navy text-sm mt-3' title='Total Kilo'><i class='fa fa-tachometer-alt'></i> $stockKilos</span> ".
                "<span class='badge bg-navy text-sm mt-3' title='Sacks'><i class='fa fa-shopping-bag'></i> $stockSacks</span>",
                ($value->prstockId?
                    "<span class='badge bg-teal mb-2' title='Purchase Request Code'>$value->purchaseRequestCode</span> ".
                    "<span class='badge bg-yellow mb-2' title='Stock Code'>$value->stockCode</span><br/> ".

                    "<span class='badge bg-gradient-success text-md mb-1' title='Sold to Member'>$value->soldToPersonFullName</span><br/>".
                    "<span class='badge bg-navy text-sm mb-1' title='Total Kilo'><i class='fa fa-tachometer-alt'></i> $pRequestNumKilos</span> ".
                    "<span class='badge bg-navy text-sm mb-1' title='Sacks'><i class='fa fa-money-bill-alt'></i> $pRequestPrice</span> ".
                    "<span class='badge bg-gradient-info text-sm mb-2' title='Purchase Request Date'><i class='fa fa-calendar'></i> $value->datePRequest</span> <br/>".
                    "<span class='badge bg-primary text-sm' title='Classification'>$value->category</span> ".
                    "<span class='badge bg-primary text-sm' title='Subclass' disabled>$value->subclass</span> "
                :"-"),
            ];
        }
        echo json_encode($data);
    }

    function getScannedQR(){
        $data = ["data" => []];
        $thisQuery=$this->db->query("SELECT * FROM view_scannedqr_logs");
        $cc=1;
        foreach ($thisQuery->result() as $key => $value) {
            $id = $value->id;
            $data["data"][] = [
                $cc++,
                $value->description,
                $value->time_format,
                $value->fullname,
            ];
        }
        echo json_encode($data);
    }

    function getQRPerson(){
        $data = ["data" => []];
        $dataTemp = [];
        $filter = $this->input->post("v");
        $personId = null;
        // $user_id = $this->session->schoolmis_login_id;
        $thisQuery=$this->db->query("SELECT * FROM view_person WHERE uuid='$filter' LIMIT 1");
        if($thisQuery){
            foreach ($thisQuery->result() as $key => $value) {
                $data["data"][] = [
                    "fullName" => $value->fullname,
                    "description" => $value->description,
                ];
                $personId = $value->id;
                $this->QRlog($personId,true,96);
            }
        }
        echo json_encode($data);
    }

    function getMemberUserList(){
        $data = ["data" => []];
        $dataTemp = [];
        $filter = $this->input->post("v");
        $user_id = $this->session->schoolmis_login_id;
        $thisQuery=$this->db->query("SELECT * FROM view_person");
        foreach ($thisQuery->result() as $key => $value) {
            if($filter && $filter==$value->partyId){
                $data["data"][] = [
                    "id" => $value->id,
                    "item" => $value->fullName,
                ];
            }else if($filter == null){
                $data["data"][] = [
                    "id" => $value->id,
                    "item" => $value->fullName,
                ];
            }
        }
        echo json_encode($data);
    }

}?>