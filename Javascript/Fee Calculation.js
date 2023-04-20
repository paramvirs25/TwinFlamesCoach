/* Change Log
* 12 Feb 2023
* Updated per class basic IW 2 price to be USD 117
* 
* 28 Dec 2022
* Updated per class basic IW 1 price to be USD 135
*
* 15 Nov 2022
* For Service fee calculation, rememoved multiple input parameters and added an array to provide applicable discounts
*
* 11-11-2022
* Added successive discount for each course done by student with us.
* 
* 9 Sep 2022
* In services page:
* Replaced 30 min consultation session with 15 min consultation session
* Added 1 hour healing session
* 
* 6 August 2022
* Changed TFC_Const_FeePerClassBIW2_USD from 108 to 114
*/

//Global constants
const TFC_Const_FeePerClassBIW1_USD = 135;
const TFC_Const_FeePerClassBIW2_USD = 117;
const TFC_Const_FeePerClassAdvTFHealings1_USD = 64;

//const TFC_Const_Fee15MinPersonal_USD = 67.5;
//const TFC_Const_Fee1HourPersonal_USD = 220;

const TFC_Const_CurUSD = 'USD';
const TFC_Const_INDiscount = 33;
const TFC_Const_CollegeStudentDiscount = 20;
const TFC_Const_InterTransferChargeDiscount = 5;
const TFC_Const_USDToINR = 75;

/*
* classPackageAndDiscount - A comma seperated string containing 
*   class package, discount for package
*/
function calculateFee(perClassFee, residencyStatus, classPackageAndDiscount, isCollegeStudent, isInterTranfChargePaidByClient){

    try{
        const classesAndDiscount = classPackageAndDiscount.split(",");
        var numberOfClassesToAttend = classesAndDiscount[0];
        

        //total fee
        var totalFee = perClassFee * numberOfClassesToAttend;
        
        //Residency Discount
        var residencyStatusDiscount = residencyStatus == TFC_Const_CurUSD ? 0 : TFC_Const_INDiscount;
        
        //multiple class discount
        var multipleClassesDiscount = classesAndDiscount[1];
                
        //college student discount
        var studentDiscount = isCollegeStudent == 0 ? 0 : TFC_Const_CollegeStudentDiscount;
        
        //transfer charge discount
        var transferChargeDiscount = isInterTranfChargePaidByClient == 0 ? 0 : TFC_Const_InterTransferChargeDiscount;
        
        return calculateSuccessiveDiscount(totalFee, 
            new Array(residencyStatusDiscount,
                multipleClassesDiscount,
                studentDiscount,
                transferChargeDiscount));
    }
    catch(e){
        return e;
    }
    
}

/**
 * 
 * @param {*} serviceToAvail 
 * @param {*} residencyStatus 
 * @param {*} isCollegeStudent 
 * @param {Array} arrOtherDiscounts 
 * @returns 
 */
function calculateServiceFee(
    serviceToAvail, 
    residencyStatus,     
    isCollegeStudent,
    arrOtherDiscounts){

    try{

        //total fee
        //var totalFee = serviceToAvail == 1 ? TFC_Const_Fee15MinPersonal_USD : TFC_Const_Fee1HourPersonal_USD;
        var totalFee = serviceToAvail * (TFC_Const_FeePerClassBIW1_USD/2); //TFC_Const_Fee15MinPersonal_USD;
        
        //Residency Discount
        var residencyStatusDiscount = residencyStatus == TFC_Const_CurUSD ? 0 : TFC_Const_INDiscount;
        
        //college student discount
        var collegeStudentDiscount = isCollegeStudent == 0 ? 0 : TFC_Const_CollegeStudentDiscount;

        return calculateSuccessiveDiscount(
            totalFee, 
            new Array(
                residencyStatusDiscount,                
                collegeStudentDiscount).concat(arrOtherDiscounts)
        );
    }
    catch(e){
		console.log(e);
        return e;
    }
    
}

function calculateSuccessiveDiscount(baseFee, discountsList){
    var discountedFee = baseFee;
    for(var i=0; i<discountsList.length; i++){
        discountedFee = discountedFee - (discountedFee * discountsList[i])/100;
    }
    return Math.round(discountedFee);
}

function calculateUSDToINR(usdValue){
    return usdValue * TFC_Const_USDToINR;
}