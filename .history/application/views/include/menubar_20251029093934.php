<?php 
$controllermenu=$this->router->fetch_class();
$functionmenu=$this->router->fetch_method();

$menuprivilegearray=$menuaccess;

if($functionmenu=='Useraccount'){
    $addcheck=checkprivilege($menuprivilegearray, 1, 1);
    $editcheck=checkprivilege($menuprivilegearray, 1, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 1, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 1, 4);
}
else if($functionmenu=='Usertype'){
    $addcheck=checkprivilege($menuprivilegearray, 2, 1);
    $editcheck=checkprivilege($menuprivilegearray, 2, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 2, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 2, 4);
}
else if($functionmenu=='Userprivilege'){
    $addcheck=checkprivilege($menuprivilegearray, 3, 1);
    $editcheck=checkprivilege($menuprivilegearray, 3, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 3, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 3, 4);
}
else if($functionmenu=='Userprivilege'){
    $addcheck=checkprivilege($menuprivilegearray, 3, 1);
    $editcheck=checkprivilege($menuprivilegearray, 3, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 3, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 3, 4);
}
else if($controllermenu=='Materialcategory'){
    $addcheck=checkprivilege($menuprivilegearray, 4, 1);
    $editcheck=checkprivilege($menuprivilegearray, 4, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 4, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 4, 4);
}
else if($controllermenu=='Brand'){
    $addcheck=checkprivilege($menuprivilegearray, 5, 1);
    $editcheck=checkprivilege($menuprivilegearray, 5, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 5, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 5, 4);
}
else if($controllermenu=='Form'){
    $addcheck=checkprivilege($menuprivilegearray, 6, 1);
    $editcheck=checkprivilege($menuprivilegearray, 6, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 6, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 6, 4);
}
else if($controllermenu=='Grade'){
    $addcheck=checkprivilege($menuprivilegearray, 7, 1);
    $editcheck=checkprivilege($menuprivilegearray, 7, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 7, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 7, 4);
}
else if($controllermenu=='Size'){
    $addcheck=checkprivilege($menuprivilegearray, 8, 1);
    $editcheck=checkprivilege($menuprivilegearray, 8, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 8, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 8, 4);
}
else if($controllermenu=='Side'){
    $addcheck=checkprivilege($menuprivilegearray, 9, 1);
    $editcheck=checkprivilege($menuprivilegearray, 9, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 9, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 9, 4);
}
else if($controllermenu=='Unittype'){
    $addcheck=checkprivilege($menuprivilegearray, 10, 1);
    $editcheck=checkprivilege($menuprivilegearray, 10, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 10, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 10, 4);
}
else if($controllermenu=='Unit'){
    $addcheck=checkprivilege($menuprivilegearray, 11, 1);
    $editcheck=checkprivilege($menuprivilegearray, 11, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 11, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 11, 4);
}
else if($controllermenu=='Materialcode'){
    $addcheck=checkprivilege($menuprivilegearray, 12, 1);
    $editcheck=checkprivilege($menuprivilegearray, 12, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 12, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 12, 4);
}
else if($controllermenu=='Materialdetail'){
    $addcheck=checkprivilege($menuprivilegearray, 13, 1);
    $editcheck=checkprivilege($menuprivilegearray, 13, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 13, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 13, 4);
}
else if($controllermenu=='Purchaseorder'){
    $addcheck=checkprivilege($menuprivilegearray, 14, 1);
    $editcheck=checkprivilege($menuprivilegearray, 14, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 14, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 14, 4);
}
else if($controllermenu=='Goodreceive'){
    $addcheck=checkprivilege($menuprivilegearray, 15, 1);
    $editcheck=checkprivilege($menuprivilegearray, 15, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 15, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 15, 4);
}
else if($controllermenu=='Supplier'){
    $addcheck=checkprivilege($menuprivilegearray, 16, 1);
    $editcheck=checkprivilege($menuprivilegearray, 16, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 16, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 16, 4);
}
else if($controllermenu=='Location'){
    $addcheck=checkprivilege($menuprivilegearray, 17, 1);
    $editcheck=checkprivilege($menuprivilegearray, 17, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 17, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 17, 4);
}
else if($controllermenu=='Qualitycheck'){
    $addcheck=checkprivilege($menuprivilegearray, 18, 1);
    $editcheck=checkprivilege($menuprivilegearray, 18, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 18, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 18, 4);
}
else if($controllermenu=='Employee'){
    $addcheck=checkprivilege($menuprivilegearray, 19, 1);
    $editcheck=checkprivilege($menuprivilegearray, 19, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 19, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 19, 4);
}
else if($controllermenu=='Factory'){
    $addcheck=checkprivilege($menuprivilegearray, 20, 1);
    $editcheck=checkprivilege($menuprivilegearray, 20, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 20, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 20, 4);
}
else if($controllermenu=='Factoryline'){
    $addcheck=checkprivilege($menuprivilegearray, 21, 1);
    $editcheck=checkprivilege($menuprivilegearray, 21, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 21, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 21, 4);
}
else if($controllermenu=='Customer'){
    $addcheck=checkprivilege($menuprivilegearray, 22, 1);
    $editcheck=checkprivilege($menuprivilegearray, 22, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 22, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 22, 4);
}
else if($controllermenu=='Machine'){
    $addcheck=checkprivilege($menuprivilegearray, 23, 1);
    $editcheck=checkprivilege($menuprivilegearray, 23, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 23, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 23, 4);
}
else if($controllermenu=='Product'){
    $addcheck=checkprivilege($menuprivilegearray, 24, 1);
    $editcheck=checkprivilege($menuprivilegearray, 24, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 24, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 24, 4);
}
else if($controllermenu=='ProductCategory'){
    $addcheck=checkprivilege($menuprivilegearray, 25, 1);
    $editcheck=checkprivilege($menuprivilegearray, 25, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 25, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 25, 4);
}
else if($controllermenu=='Customerporder'){
    $addcheck=checkprivilege($menuprivilegearray, 26, 1);
    $editcheck=checkprivilege($menuprivilegearray, 26, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 26, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 26, 4);
}
else if($controllermenu=='Production'){
    $addcheck=checkprivilege($menuprivilegearray, 27, 1);
    $editcheck=checkprivilege($menuprivilegearray, 27, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 27, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 27, 4);
}
else if($controllermenu=='ProductSubCategory'){
    $addcheck=checkprivilege($menuprivilegearray, 28, 1);
    $editcheck=checkprivilege($menuprivilegearray, 28, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 28, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 28, 4);
}
else if($controllermenu=='Finishgoodbom'){
    $addcheck=checkprivilege($menuprivilegearray, 29, 1);
    $editcheck=checkprivilege($menuprivilegearray, 29, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 29, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 29, 4);
}
else if($controllermenu=='Prodcutionprocess'){
    $addcheck=checkprivilege($menuprivilegearray, 30, 1);
    $editcheck=checkprivilege($menuprivilegearray, 30, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 30, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 30, 4);
}
else if($controllermenu=='Packfinishgood'){
    $addcheck=checkprivilege($menuprivilegearray, 31, 1);
    $editcheck=checkprivilege($menuprivilegearray, 31, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 31, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 31, 4);
}
else if($controllermenu=='Expences'){
    $addcheck=checkprivilege($menuprivilegearray, 32, 1);
    $editcheck=checkprivilege($menuprivilegearray, 32, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 32, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 32, 4);
}
else if($controllermenu=='Expencetype'){
    $addcheck=checkprivilege($menuprivilegearray, 33, 1);
    $editcheck=checkprivilege($menuprivilegearray, 33, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 33, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 33, 4);
}
else if($controllermenu=='Ordertype'){
    $addcheck=checkprivilege($menuprivilegearray, 34, 1);
    $editcheck=checkprivilege($menuprivilegearray, 34, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 34, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 34, 4);
}
else if($controllermenu=='RptGRN'){
    $addcheck=checkprivilege($menuprivilegearray, 35, 1);
    $editcheck=checkprivilege($menuprivilegearray, 35, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 35, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 35, 4);
}
else if($controllermenu=='Rptmatstock'){
    $addcheck=checkprivilege($menuprivilegearray, 36, 1);
    $editcheck=checkprivilege($menuprivilegearray, 36, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 36, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 36, 4);
}
else if($controllermenu=='Rptsalesorder'){
    $addcheck=checkprivilege($menuprivilegearray, 37, 1);
    $editcheck=checkprivilege($menuprivilegearray, 37, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 37, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 37, 4);
}
else if($controllermenu=='Qualitycategory'){
    $addcheck=checkprivilege($menuprivilegearray, 38, 1);
    $editcheck=checkprivilege($menuprivilegearray, 38, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 38, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 38, 4);
}
else if($controllermenu=='Qualitysubcategory'){
    $addcheck=checkprivilege($menuprivilegearray, 39, 1);
    $editcheck=checkprivilege($menuprivilegearray, 39, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 39, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 39, 4);
}
else if($controllermenu=='Directsale'){
    $addcheck=checkprivilege($menuprivilegearray, 40, 1);
    $editcheck=checkprivilege($menuprivilegearray, 40, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 40, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 40, 4);
}
else if($controllermenu=='Invoice'){
    $addcheck=checkprivilege($menuprivilegearray, 41, 1);
    $editcheck=checkprivilege($menuprivilegearray, 41, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 41, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 41, 4);
}
else if($controllermenu=='Productionorderview'){
    $addcheck=checkprivilege($menuprivilegearray, 42, 1);
    $editcheck=checkprivilege($menuprivilegearray, 42, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 42, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 42, 4);
}
else if($controllermenu=='Salesordercost'){
    $addcheck=checkprivilege($menuprivilegearray, 43, 1);
    $editcheck=checkprivilege($menuprivilegearray, 43, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 43, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 43, 4);
}
else if($controllermenu=='Productionmaterialissue'){
    $addcheck=checkprivilege($menuprivilegearray, 44, 1);
    $editcheck=checkprivilege($menuprivilegearray, 44, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 44, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 44, 4);
}
else if($controllermenu=='Productiontranspacking'){
    $addcheck=checkprivilege($menuprivilegearray, 45, 1);
    $editcheck=checkprivilege($menuprivilegearray, 45, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 45, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 45, 4);
}
else if($controllermenu=='Productiontranslabeling'){
    $addcheck=checkprivilege($menuprivilegearray, 46, 1);
    $editcheck=checkprivilege($menuprivilegearray, 46, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 46, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 46, 4);
}
else if($controllermenu=='Rptproductwisesales'){
    $addcheck=checkprivilege($menuprivilegearray, 47, 1);
    $editcheck=checkprivilege($menuprivilegearray, 47, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 47, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 47, 4);
}
else if($controllermenu=='Rptbuyerwisesales'){
    $addcheck=checkprivilege($menuprivilegearray, 48, 1);
    $editcheck=checkprivilege($menuprivilegearray, 48, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 48, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 48, 4);
}
else if($controllermenu=='Rptfgstock'){
    $addcheck=checkprivilege($menuprivilegearray, 49, 1);
    $editcheck=checkprivilege($menuprivilegearray, 49, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 49, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 49, 4);
}
else if($controllermenu=='Rptsemiproduct'){
    $addcheck=checkprivilege($menuprivilegearray, 50, 1);
    $editcheck=checkprivilege($menuprivilegearray, 50, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 50, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 50, 4);
}
else if($controllermenu=='Directinvoice'){
    $addcheck=checkprivilege($menuprivilegearray, 51, 1);
    $editcheck=checkprivilege($menuprivilegearray, 51, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 51, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 51, 4);
}
else if($controllermenu=='Productionfg'){
    $addcheck=checkprivilege($menuprivilegearray, 52, 1);
    $editcheck=checkprivilege($menuprivilegearray, 52, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 52, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 52, 4);
}
else if($controllermenu=='Semibom'){
    $addcheck=checkprivilege($menuprivilegearray, 53, 1);
    $editcheck=checkprivilege($menuprivilegearray, 53, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 53, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 53, 4);
}
else if($controllermenu=='Semiproduction'){
    $addcheck=checkprivilege($menuprivilegearray, 54, 1);
    $editcheck=checkprivilege($menuprivilegearray, 54, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 54, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 54, 4);
}
else if($controllermenu=='Semiothercost'){
    $addcheck=checkprivilege($menuprivilegearray, 55, 1);
    $editcheck=checkprivilege($menuprivilegearray, 55, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 55, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 55, 4);
}
else if($controllermenu=='Invoiceview'){
    $addcheck=checkprivilege($menuprivilegearray, 56, 1);
    $editcheck=checkprivilege($menuprivilegearray, 56, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 56, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 56, 4);
}
else if($controllermenu=='Productionpacking'){
    $addcheck=checkprivilege($menuprivilegearray, 57, 1);
    $editcheck=checkprivilege($menuprivilegearray, 57, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 57, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 57, 4);
}
else if($controllermenu=='Rptmatstockbatchwise'){
    $addcheck=checkprivilege($menuprivilegearray, 58, 1);
    $editcheck=checkprivilege($menuprivilegearray, 58, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 58, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 58, 4);
}
else if($controllermenu=='Rptfgstockbatchwise'){
    $addcheck=checkprivilege($menuprivilegearray, 59, 1);
    $editcheck=checkprivilege($menuprivilegearray, 59, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 59, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 59, 4);
}
else if($controllermenu=='Semiproductionquality'){
    $addcheck=checkprivilege($menuprivilegearray, 60, 1);
    $editcheck=checkprivilege($menuprivilegearray, 60, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 60, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 60, 4);
}
else if($controllermenu=='Productionpackingquality'){
    $addcheck=checkprivilege($menuprivilegearray, 61, 1);
    $editcheck=checkprivilege($menuprivilegearray, 61, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 61, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 61, 4);
}
else if($controllermenu=='Miscellaneous'){
    $addcheck=checkprivilege($menuprivilegearray, 62, 1);
    $editcheck=checkprivilege($menuprivilegearray, 62, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 62, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 62, 4);
}
else if($controllermenu=='Rptinvoicesummary'){
    $addcheck=checkprivilege($menuprivilegearray, 63, 1);
    $editcheck=checkprivilege($menuprivilegearray, 63, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 63, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 63, 4);
}
else if($functionmenu=='Semiproductionprocess'){
    $addcheck=checkprivilege($menuprivilegearray, 64, 1);
    $editcheck=checkprivilege($menuprivilegearray, 64, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 64, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 64, 4);
}
else if($controllermenu=='Rptmaterialtransaction'){
    $addcheck=checkprivilege($menuprivilegearray, 65, 1);
    $editcheck=checkprivilege($menuprivilegearray, 65, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 65, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 65, 4);
}
else if($controllermenu=='Returninvoice'){
    $addcheck=checkprivilege($menuprivilegearray, 66, 1);
    $editcheck=checkprivilege($menuprivilegearray, 66, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 66, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 66, 4);
}
else if($controllermenu=='Returntype'){
    $addcheck=checkprivilege($menuprivilegearray, 67, 1);
    $editcheck=checkprivilege($menuprivilegearray, 67, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 67, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 67, 4);
}
else if($controllermenu=='Invoicebank'){
    $addcheck=checkprivilege($menuprivilegearray, 68, 1);
    $editcheck=checkprivilege($menuprivilegearray, 68, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 68, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 68, 4);
}
else if($controllermenu=='Rptstocksummery'){
    $addcheck=checkprivilege($menuprivilegearray, 69, 1);
    $editcheck=checkprivilege($menuprivilegearray, 69, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 69, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 69, 4);
}
else if($controllermenu=='Rptsemimaterialsummery'){
    $addcheck=checkprivilege($menuprivilegearray, 70, 1);
    $editcheck=checkprivilege($menuprivilegearray, 70, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 70, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 70, 4);
}
else if($controllermenu=='SemiBomOtherCostCharge'){
    $addcheck=checkprivilege($menuprivilegearray, 71, 1);
    $editcheck=checkprivilege($menuprivilegearray, 71, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 71, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 71, 4);
}
else if($controllermenu=='Materialtransfer'){
    $addcheck=checkprivilege($menuprivilegearray, 72, 1);
    $editcheck=checkprivilege($menuprivilegearray, 72, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 72, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 72, 4);
}
else if($controllermenu=='Returninvoiceview'){
    $addcheck=checkprivilege($menuprivilegearray, 73, 1);
    $editcheck=checkprivilege($menuprivilegearray, 73, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 73, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 73, 4);
}
else if($controllermenu=='Company'){
    $addcheck=checkprivilege($menuprivilegearray, 74, 1);
    $editcheck=checkprivilege($menuprivilegearray, 74, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 74, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 74, 4);
}
else if($controllermenu=='Companybranch'){
    $addcheck=checkprivilege($menuprivilegearray, 75, 1);
    $editcheck=checkprivilege($menuprivilegearray, 75, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 75, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 75, 4);
}

function checkprivilege($arraymenu, $menuID, $type){
    foreach($arraymenu as $array){
        if($array->menuid==$menuID){
            if($type==1){
                return $array->add;
            }
            else if($type==2){
                return $array->edit;
            }
            else if($type==3){
                return $array->statuschange;
            }
            else if($type==4){
                return $array->remove;
            }
        }
    }
}

?>
<textarea class="d-none" id="actiontext"><?php if($this->session->flashdata('msg')) {echo $this->session->flashdata('msg');} ?></textarea>

<nav class="sidenav shadow-right sidenav-light">
    <div class="sidenav-menu">
        <div class="nav accordion" id="accordionSidenav">
            <div class="sidenav-menu-heading">Core</div>
            <a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url().'Welcome/Dashboard'; ?>">
                <div class="nav-link-icon"><i class="fas fa-desktop"></i></div>
                Dashboard
            </a>
            <?php if(menucheck($menuprivilegearray, 35)==1 | menucheck($menuprivilegearray, 36)==1 | menucheck($menuprivilegearray, 49)==1 | menucheck($menuprivilegearray, 37)==1 | menucheck($menuprivilegearray, 47)==1 | menucheck($menuprivilegearray, 48)==1 | menucheck($menuprivilegearray, 50)==1 | menucheck($menuprivilegearray, 58)==1 | menucheck($menuprivilegearray, 59)==1 | menucheck($menuprivilegearray, 63)==1 | menucheck($menuprivilegearray, 65)==1 | menucheck($menuprivilegearray, 69)==1 | menucheck($menuprivilegearray, 70)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseReports" aria-expanded="false" aria-controls="collapseReports">
                <div class="nav-link-icon"><i class="fas fa-file-alt"></i></div>
                Reports
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if($controllermenu=="RptGRN" | $controllermenu=="Rptmatstock" | $controllermenu=="Rptfgstock" | $controllermenu=="Rptsalesorder" | $controllermenu=="Rptproductwisesales" | $controllermenu=="Rptbuyerwisesales" | $controllermenu=="Rptsemiproduct" | $controllermenu=="Rptmatstockbatchwise" | $controllermenu=="Rptfgstockbatchwise" | $controllermenu=="Rptinvoicesummary" | $controllermenu=="Rptmaterialtransaction" | $controllermenu=="Rptstocksummery" | $controllermenu=="Rptsemimaterialsummery"){echo 'show';} ?>" id="collapseReports" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <!-- <?php //if(menucheck($menuprivilegearray, 35)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'RptGRN'; ?>">GRN Report</a> -->
                    <?php if(menucheck($menuprivilegearray, 36)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Rptmatstockbatchwise'; ?>">Material Stock Batch Wise Report</a>
                    <?php } if(menucheck($menuprivilegearray, 58)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Rptmatstock'; ?>">Material Stock Report</a>
                    <!-- <?php //} if(menucheck($menuprivilegearray, 49)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Rptfgstockbatchwise'; ?>">Finish Good Stock Batch Wise Report</a>
                    <?php //} if(menucheck($menuprivilegearray, 59)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Rptfgstock'; ?>">Finish Good Stock Report</a>
                    <?php //} if(menucheck($menuprivilegearray, 37)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Rptsalesorder'; ?>">Sales Order Report</a>
                    <?php //} if(menucheck($menuprivilegearray, 47)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Rptproductwisesales'; ?>">Product Wise Sales Report</a>
                    <?php //} if(menucheck($menuprivilegearray, 48)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Rptbuyerwisesales'; ?>">Buyer Wise Sales Report</a>
                    <?php //} if(menucheck($menuprivilegearray, 50)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Rptsemiproduct'; ?>">Semi Product Report</a>
                    <?php //} if(menucheck($menuprivilegearray, 63)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Rptinvoicesummary'; ?>">Invoice Summary Report</a>
                    <?php //} if(menucheck($menuprivilegearray, 65)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Rptmaterialtransaction'; ?>">Material Transaction Report</a>
                    <?php //} if(menucheck($menuprivilegearray, 69)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Rptstocksummery'; ?>">Stock Summery Report</a>
                    <?php //} if(menucheck($menuprivilegearray, 70)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Rptsemimaterialsummery'; ?>">Semi Summery Report</a> -->
                    <?php } ?>
                </nav>
            </div>
            <?php } if(menucheck($menuprivilegearray, 22)==1){ ?> 
            <a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url().'Customer'; ?>">
                <div class="nav-link-icon"><i class="fas fa-users"></i></div>
                Customer
            </a>
            <?php }if(menucheck($menuprivilegearray, 16)==1){ ?> 
            <a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url().'Supplier'; ?>">
                <div class="nav-link-icon"><i class="fas fa-users"></i></div>
                Supplier
            </a>
            <?php } if(menucheck($menuprivilegearray, 4)==1 | menucheck($menuprivilegearray, 11)==1 | menucheck($menuprivilegearray, 13)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseMaterialinfo" aria-expanded="false" aria-controls="collapseMaterialinfo">
                <div class="nav-link-icon"><i class="fas fa-shopping-basket"></i></div>
                Material Information
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if($controllermenu=="Materialcategory" | $controllermenu=="Materialdetail"){echo 'show';} ?>" id="collapseMaterialinfo" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <?php if(menucheck($menuprivilegearray, 4)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Materialcategory'; ?>">Material Category</a>
                    <?php } if(menucheck($menuprivilegearray, 11)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Unit'; ?>">Unit</a>
                    <?php } if(menucheck($menuprivilegearray, 13)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Materialdetail'; ?>">Material Detail</a>
                    <?php } ?>
                </nav>
            </div>
            <?php } if(menucheck($menuprivilegearray, 24)==1 | menucheck($menuprivilegearray, 25)==1 | menucheck($menuprivilegearray, 28)==1 | menucheck($menuprivilegearray, 29)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseproductinfo" aria-expanded="false" aria-controls="collapseproductinfo">
                <div class="nav-link-icon"><i class="fas fa-briefcase"></i></div>
                Finish Good
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if($controllermenu=="Product" | $controllermenu=="Finishgoodbom"){echo 'show';} ?>" id="collapseproductinfo" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <?php if(menucheck($menuprivilegearray, 24)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Product'; ?>">Finish Good</a>
                    <?php } if(menucheck($menuprivilegearray, 25)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'ProductCategory'; ?>">Product Category</a> 
                    <?php } if(menucheck($menuprivilegearray, 28)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'ProductSubCategory'; ?>">Product Sub Category</a>
                    <?php } if(menucheck($menuprivilegearray, 29)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Finishgoodbom'; ?>">Finish Good BOM</a>
                    <?php } ?>
                </nav>
            </div>
            <!-- <?php //} if(menucheck($menuprivilegearray, 26)==1 | menucheck($menuprivilegearray, 43)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseSalesinfo" aria-expanded="false" aria-controls="collapseSalesinfo">
                <div class="nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                Sales Information
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php //if($controllermenu=="Customerporder" | $controllermenu=="Salesordercost"){echo 'show';} ?>" id="collapseSalesinfo" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <?php //if(menucheck($menuprivilegearray, 26)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Customerporder'; ?>">Sales Order</a>
                    <?php //} if(menucheck($menuprivilegearray, 43)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Salesordercost'; ?>">Sales Order Cost List</a>
                    <?php //} ?>
                </nav>
            </div> -->
            <?php } if(menucheck($menuprivilegearray, 14)==1 | menucheck($menuprivilegearray, 15)==1 | menucheck($menuprivilegearray, 18)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse" data-target="#collapsepordergrn" aria-expanded="false" aria-controls="collapsepordergrn">
                <div class="nav-link-icon"><i class="fas fa-truck"></i></div>
                Porder & GRN Info
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if($controllermenu=="Purchaseorder" | $controllermenu=="Goodreceive" | $controllermenu=="Qualitycheck"){echo 'show';} ?>" id="collapsepordergrn" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <?php if(menucheck($menuprivilegearray, 14)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Purchaseorder'; ?>">Purchase Order</a>
                    <?php } if(menucheck($menuprivilegearray, 15)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Goodreceive'; ?>">Good Receive Note</a>
                    <?php } if(menucheck($menuprivilegearray, 18)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Qualitycheck'; ?>">Quality Check</a>
                    <?php } ?>
                </nav>
            </div>
            <!-- <?php //} if(menucheck($menuprivilegearray, 53)==1 | menucheck($menuprivilegearray, 54)==1 | menucheck($menuprivilegearray, 60)==1 | menucheck($menuprivilegearray, 64)==1 | menucheck($menuprivilegearray, 71)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseSemi" aria-expanded="false" aria-controls="collapseSemi">
                <div class="nav-link-icon"><i class="fas fa-sitemap"></i></div>
                Production
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php //if($controllermenu=="Semibom" | $controllermenu=="Semiproduction" | $controllermenu=="Semiproductionquality" | $functionmenu=="Semiproductionprocess" | $controllermenu=="SemiBomOtherCostCharge"){echo 'show';} ?>" id="collapseSemi" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <?php //if(menucheck($menuprivilegearray, 53)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Semibom'; ?>">Production BOM</a>
                    <?php //} if(menucheck($menuprivilegearray, 71)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'SemiBomOtherCostCharge'; ?>">Production Other Cost</a>
                    <?php //} if(menucheck($menuprivilegearray, 54)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Semiproduction'; ?>">Prodcution Order</a>
                    <?php //} if(menucheck($menuprivilegearray, 64)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Semiproduction/Semiproductionprocess'; ?>">Prodcution Process</a>
                    <?php //} if(menucheck($menuprivilegearray, 60)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Semiproductionquality'; ?>">Prodcution Quality</a>
                    <?php //} ?>
                </nav>
            </div> -->
            <?php } if(menucheck($menuprivilegearray, 42)==1 | menucheck($menuprivilegearray, 61)==1 | menucheck($menuprivilegearray, 45)==1 | menucheck($menuprivilegearray, 46)==1 | menucheck($menuprivilegearray, 57)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseProdcution" aria-expanded="false" aria-controls="collapseProdcution">
                <div class="nav-link-icon"><i class="fas fa-list"></i></div>
                Packing
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if($controllermenu=="Productionorderview" | $controllermenu=="Productionpackingquality" | $controllermenu=="Productiontranspacking" | $controllermenu=="Productiontranslabeling" | $controllermenu=="Productionpacking"){echo 'show';} ?>" id="collapseProdcution" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <?php if(menucheck($menuprivilegearray, 42)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Productionorderview'; ?>">Packing Order</a>
                    <?php } if(menucheck($menuprivilegearray, 57)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Productionpacking'; ?>">Packing Records</a>
                    <?php } if(menucheck($menuprivilegearray, 61)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Productionpackingquality'; ?>">Packing Quality</a>
                    <?php } if(menucheck($menuprivilegearray, 45)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Productiontranspacking'; ?>">Production Trans. Packing</a>
                    <?php } if(menucheck($menuprivilegearray, 46)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Productiontranslabeling'; ?>">Production Trans. Labelling</a>
                    <?php } ?>
                </nav>
            </div>
            <!-- <?php //} if(menucheck($menuprivilegearray, 40)==1  | menucheck($menuprivilegearray, 51)==1 | menucheck($menuprivilegearray, 56)==1 | menucheck($menuprivilegearray, 66)==1| menucheck($menuprivilegearray, 68)==1 | menucheck($menuprivilegearray, 73)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
            	data-target="#collapseshopinfo" aria-expanded="false" aria-controls="collapseshopinfo">
            	<div class="nav-link-icon"><i class="fas fa-cash-register"></i></div>
            	Invoice
            	<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php //if($controllermenu=="Directsale" | $controllermenu=="Directinvoice" | $controllermenu=="Invoiceview" | $controllermenu=="Returninvoice"| $controllermenu=="Invoicebank" | $controllermenu=="Returninvoiceview"){echo 'show';} ?>"
            	id="collapseshopinfo" data-parent="#accordionSidenav">
            	<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
            		<?php //if(menucheck($menuprivilegearray, 40)==1){ ?>
            		<a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Directsale'; ?>">Outlet Invoice</a> 
                    <?php //} if(menucheck($menuprivilegearray, 51)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Directinvoice'; ?>">Direct Invoice</a>
                    <?php //} if(menucheck($menuprivilegearray, 56)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Invoiceview'; ?>">View Invoice</a>
                    <?php //} if(menucheck($menuprivilegearray, 66)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Returninvoice'; ?>">Create Return Invoice</a>
                    <?php //} if(menucheck($menuprivilegearray, 73)==1){ ?>
                        <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Returninvoiceview'; ?>">View Return Invoice</a>
                    <?php //} if(menucheck($menuprivilegearray, 68)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Invoicebank'; ?>">Invoice Bank</a>
                    <?php //} ?>
            	</nav>
            </div> -->
            <!-- <?php //} if(menucheck($menuprivilegearray, 52)==1){ ?> 
            <a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url().'Productionfg'; ?>">
                <div class="nav-link-icon"><i class="fas fa-exchange-alt"></i></div>
                Finish Good Transaction
            </a>
            <?php //} if(menucheck($menuprivilegearray, 72)==1){ ?> 
            <a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url().'Materialtransfer'; ?>">
                <div class="nav-link-icon"><i class="fas fa-exchange-alt"></i></div>
                Material Transaction
            </a>
            <?php //} if(menucheck($menuprivilegearray, 62)==1){ ?> 
            <a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url().'Miscellaneous'; ?>">
                <div class="nav-link-icon"><i class="fas fa-random"></i></div>
                Miscellaneous
            </a>
            <?php //} if(menucheck($menuprivilegearray, 20)==1 | menucheck($menuprivilegearray, 21)==1 | menucheck($menuprivilegearray, 23)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseFactory" aria-expanded="false" aria-controls="collapseFactory">
                <div class="nav-link-icon"><i class="fas fa-industry"></i></div>
                Factory
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php //if($controllermenu=="Factory" | $controllermenu=="Factoryline" | $controllermenu=="Machine"){echo 'show';} ?>" id="collapseFactory" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <?php //if(menucheck($menuprivilegearray, 20)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Factory'; ?>">Factory</a>
                    <?php //} if(menucheck($menuprivilegearray, 21)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Factoryline'; ?>">Factory Line</a>
                    <?php //} if(menucheck($menuprivilegearray, 23)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Machine'; ?>">Machine</a>
                    <?php //} ?>
                </nav>
            </div> -->
            <?php } if(menucheck($menuprivilegearray, 17)==1){ ?> 
            <a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url().'Location'; ?>">
                <div class="nav-link-icon"><i class="fas fa-map-marker"></i></div>
                Location
            </a>
            <?php } if(menucheck($menuprivilegearray, 74)==1 | menucheck($menuprivilegearray, 75)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseCompany" aria-expanded="false" aria-controls="collapseCompany">
                <div class="nav-link-icon"><i class="fas fa-building"></i></div>
                Company Information
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if($controllermenu=="Company" | $controllermenu=="Companybranch"){echo 'show';} ?>" id="collapseCompany" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <?php if(menucheck($menuprivilegearray, 74)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Company'; ?>">Company</a>
                    <?php } if(menucheck($menuprivilegearray, 75)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Companybranch'; ?>">Company Branch</a>
                    <?php } ?>
                </nav>
            </div>
            <?php } if(menucheck($menuprivilegearray, 19)==1){ ?> 
            <a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url().'Employee'; ?>">
                <div class="nav-link-icon"><i class="fas fa-user"></i></div>
                Employee
            </a>
            <!-- <?php //} if(menucheck($menuprivilegearray, 32)==1 | menucheck($menuprivilegearray, 33)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseexpences" aria-expanded="false" aria-controls="collapseexpences">
                <div class="nav-link-icon"><i class="fas fa-wallet"></i></div>
                Costing
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php //if($controllermenu=="Expences" | $controllermenu=="Expencetype"){echo 'show';} ?>" id="collapseexpences" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <?php //if(menucheck($menuprivilegearray, 32)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Expences'; ?>">Costing</a>
                    <?php //} if(menucheck($menuprivilegearray, 33)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Expencetype'; ?>">Costing Type</a>
                    <?php //} ?>
                </nav>
            </div> -->
            <?php } if(menucheck($menuprivilegearray, 34)==1 | menucheck($menuprivilegearray, 38)==1 | menucheck($menuprivilegearray, 39)==1 | menucheck($menuprivilegearray, 67)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseOthers" aria-expanded="false" aria-controls="collapseOthers">
                <div class="nav-link-icon"><i class="fas fa-list"></i></div>
                Others
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if($controllermenu=="Ordertype" | $controllermenu=="Qualitycategory" | $controllermenu=="Qualitysubcategory" | $controllermenu=="Returntype"){echo 'show';} ?>" id="collapseOthers" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <?php if(menucheck($menuprivilegearray, 34)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Ordertype'; ?>">Order Type</a>
                    <!-- <?php //} if(menucheck($menuprivilegearray, 67)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Returntype'; ?>">Return Type</a>
                    <?php //} if(menucheck($menuprivilegearray, 38)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Qualitycategory'; ?>">Quality Category</a>
                    <?php //} if(menucheck($menuprivilegearray, 39)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'Qualitysubcategory'; ?>">Quality Subcategory</a> -->
                    <?php } ?>
                </nav>
            </div>
            <?php } if(menucheck($menuprivilegearray, 1)==1 | menucheck($menuprivilegearray, 2)==1 | menucheck($menuprivilegearray, 3)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseUser" aria-expanded="false" aria-controls="collapseUser">
                <div class="nav-link-icon"><i class="fas fa-user"></i></div>
                User Account
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if($functionmenu=="Useraccount" | $functionmenu=="Usertype" | $functionmenu=="Userprivilege"){echo 'show';} ?>" id="collapseUser" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <?php if(menucheck($menuprivilegearray, 1)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'User/Useraccount'; ?>">User Account</a>
                    <?php } if(menucheck($menuprivilegearray, 2)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'User/Usertype'; ?>">Type</a>
                    <?php } if(menucheck($menuprivilegearray, 3)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'User/Userprivilege'; ?>">Privilege</a>
                    <?php } ?>
                </nav>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="sidenav-footer">
        <div class="sidenav-footer-content">
            <div class="sidenav-footer-subtitle">Logged in as:</div>
            <div class="sidenav-footer-title"><?php echo ucfirst($_SESSION['name']); ?></div>
        </div>
    </div>
</nav>
