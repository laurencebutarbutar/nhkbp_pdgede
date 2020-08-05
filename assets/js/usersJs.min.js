$(document).ready(function() {
    document.getElementById("registerEvents").children[2].style.display = "none";
    document.getElementById("registerEvents").children[3].style.display = "none";
    document.getElementById("registerEvents").children[4].style.display = "none";
    document.getElementById("registerEvents").children[5].style.display = "none";
    document.getElementById("registerEvents").children[6].style.display = "none";
    document.getElementById("registerEvents").children[7].style.display = "none";
    document.getElementById("registerEvents").children[8].style.display = "none";
    document.getElementById("registerEvents").children[9].style.display = "none";
    document.getElementById("registerEvents").children[10].style.display = "none";
    document.getElementById("registerEvents").children[11].style.display = "none";
    $('#events').on('change', function() {
        if ($('#events').val() != 'Retret') {
            document.getElementById("registerEvents").children[2].style.display = "block";
            document.getElementById("registerEvents").children[3].style.display = "block";
        }else{
        	document.getElementById("registerEvents").children[2].style.display = "none";
            document.getElementById("registerEvents").children[3].style.display = "none";
            document.getElementById("registerEvents").children[4].style.display = "none";
		    document.getElementById("registerEvents").children[5].style.display = "none";
		    document.getElementById("registerEvents").children[6].style.display = "none";
		    document.getElementById("registerEvents").children[7].style.display = "none";
		    document.getElementById("registerEvents").children[8].style.display = "none";
		    document.getElementById("registerEvents").children[9].style.display = "none";
		    document.getElementById("registerEvents").children[10].style.display = "none";
		    document.getElementById("registerEvents").children[11].style.display = "none";
        }
    });
    $('#mode').on('change', function() {
        if ($('#mode').val() == 'Team') {
            document.getElementById("registerEvents").children[4].style.display = "block";
            document.getElementById("registerEvents").children[5].style.display = "block"
        } else {
            document.getElementById("registerEvents").children[4].style.display = "none";
            document.getElementById("registerEvents").children[5].style.display = "none";
            document.getElementById("registerEvents").children[6].style.display = "none";
            document.getElementById("registerEvents").children[7].style.display = "none";
            document.getElementById("registerEvents").children[8].style.display = "none";
            document.getElementById("registerEvents").children[9].style.display = "none";
            document.getElementById("registerEvents").children[10].style.display = "none";
            document.getElementById("registerEvents").children[11].style.display = "none";
        }
    });
    $('#teamMode').on('change', function() {
        if ($('#teamMode').val() == 'Create Team') {
            document.getElementById("registerEvents").children[6].style.display = "none";
            document.getElementById("registerEvents").children[7].style.display = "none";
            document.getElementById("registerEvents").children[8].style.display = "none";
            document.getElementById("registerEvents").children[9].style.display = "block";
            document.getElementById("registerEvents").children[10].style.display = "block";
            document.getElementById("registerEvents").children[11].style.display = "block";
        } else {
            document.getElementById("registerEvents").children[6].style.display = "block";
            document.getElementById("registerEvents").children[7].style.display = "block";
            document.getElementById("registerEvents").children[8].style.display = "block";
            document.getElementById("registerEvents").children[9].style.display = "none";
            document.getElementById("registerEvents").children[10].style.display = "none";
            document.getElementById("registerEvents").children[11].style.display = "none";
        }
    });    
});

$(document).ready(function() {
    var max_fields      = 10;
    var wrapper         = $(".input_fields_wrap");
    var add_button      = $(".add_field_button");
    var order_button    = $('#buttonOrderFood');

    var x = 0;
    $(add_button).click(function(e){
        e.preventDefault();
            if(x < max_fields){
                x++;
                $(wrapper).append('<li><a><table style="width: 100%; margin-left: -15px;"><tr><td style="width: 85%; text-align: center;" align="center"><input style="text-align: right;" type="hidden" class="form-control" name="priceBefore['+x+']" id="priceBefore['+x+']" value="0"></input><input style="text-align: right;" type="hidden" class="form-control" name="nameFood['+x+']" id="nameFood['+x+']"></input><select class="form-control" onchange="change('+x+')" name="orderFood['+x+']" id="orderFood['+x+']" required><option disabled selected value> -- Choose Food -- </option><optgroup label="B2"><option value="200000">B2 Panggang (Rp 200.000)</option><option value="200000">B2 Kecap (Rp 200.000)</option><option value="200000">Saksang (Rp 200.000)</option><optgroup label="Ayam"><option value="250000">Ayam Pinadar (Rp 250.000)</option><option value="250000">Ayam Gota (Rp 250.000)</option><option value="150000">Ayam Balado (Rp 150.000)</option></optgroup><optgroup label="Ikan Mas"><option value="150000">Ikan Mas Arsik (Rp 150.000)</option><option value="150000">Ikan Mas Tombur (Rp 150.000)</option></optgroup><optgroup label="Parcel"><option value="150000">Parcel Buah (Rp 150.000)</option></optgroup></select><td style="width: 5%;"></td><td  style="width: 10%;" align="center"><button id="buttonRemoveFood['+x+']" name="buttonRemoveFood['+x+']" onclick="removeField('+x+')" class="btn btn-danger btn-lg btn-block login-button">-</button></td></tr></table></a></li>');//add input box
            }
    });
    $(order_button).click(function(e){
        if($('#orderFood\\['+0+'\\]').val() == null){
            e.preventDefault();
            e.stopPropagation();
            alert("Oops, You Missing Order Food Field");
        }        
        else if($('#orderFoodDate').val() == null){
            e.preventDefault();
            e.stopPropagation();
            alert("Oops, You Missing Order Date Field");
        }else if($('#orderFoodTime').val() == null){
            e.preventDefault();
            e.stopPropagation();
            alert("Oops, You Missing Order Time Field");
        }else{
        }
    });
    $("#myModal").on('show.bs.modal', function () {
        var table = document.getElementById("customers");

        var modalTotalPaymentVal = $('#totalPay').val();
        var modalDateDeliveryVal = $('#orderFoodDate').val();
        var modalTimeDeliveryVal = $('#orderFoodTime').val();

        var tempArrayFood = [];
        var numArrayFood = 0;
        var tempNameFood = [];

        var current = null;
        var currentValue = null;
        var cnt = 0;
        var num = 1;

        //cek total pesanan
        for(var intFood = 0; intFood <= 10; intFood++){
            var temp = null;
            if($('#orderFood\\['+intFood+'\\]').val() != null){
                tempArrayFood[numArrayFood] = intFood;
                temp = $('#orderFood\\['+intFood+'\\]').find(":selected").text();
                // temp = temp.substr(0, temp.length-13);
                $('#nameFood\\['+intFood+'\\]').val(temp);
                tempNameFood[numArrayFood] = $('#orderFood\\['+intFood+'\\]').find(":selected").text();
                numArrayFood ++;
            }
        }

        var rows = document.getElementById("customers").rows.length;
        if(rows > 2){
            for(var z=1;z<rows-1;z++){
                document.getElementById("customers").deleteRow(1);
            }
        }

        tempNameFood.sort();
        for (var i = 0; i < tempNameFood.length; i++) {
            row = table.insertRow(num);
            if (tempNameFood[i] != current) {
                if (cnt > 0) {
                    currentValue = current.substr(current.length-8, 7);
                    currentValue = currentValue.replace(".","");
                    current = current.substr(0, current.length-13);
                    row.insertCell(0).innerHTML = num;
                    row.insertCell(1).innerHTML = current;
                    document.getElementById('customers').rows[num].cells[1].align="left";
                    row.insertCell(2).innerHTML = cnt;
                    row.insertCell(3).innerHTML = formatRupiah(parseInt(currentValue));
                    row.insertCell(4).innerHTML = formatRupiah(parseInt(currentValue)*cnt);
                    num ++;
                }
                current = tempNameFood[i];
                cnt = 1;
            } else {
                cnt++;
            }
        }
        if (cnt > 0) {
            row = table.insertRow(num);
            currentValue = current.substr(current.length-8, 7);
            currentValue = currentValue.replace(".","");
            current = current.substr(0, current.length-13);
            row.insertCell(0).innerHTML = num;            
            row.insertCell(1).innerHTML = current;
            document.getElementById('customers').rows[num].cells[1].align="left";
            row.insertCell(2).innerHTML = cnt;
            row.insertCell(3).innerHTML = formatRupiah(parseInt(currentValue));
            row.insertCell(4).innerHTML = formatRupiah(parseInt(currentValue)*cnt);
            num ++;
        }
        
        document.getElementById("modalTotalPayment").innerHTML = modalTotalPaymentVal;
        document.getElementById("modalDateDelivery").innerHTML = modalDateDeliveryVal;
        document.getElementById("modalTimeDelivery").innerHTML = modalTimeDeliveryVal;
    });
});

function change(x){
    var price_food_new = parseInt($('#orderFood\\['+x+'\\]').val());
    var price_food_old = parseInt($('#priceBefore\\['+x+'\\]').val());
    var total_pay_hidden_before = parseInt($('#totalPayHidden').val());
    var temp_total = 0;
    if(price_food_old != price_food_new){
        total_pay_hidden_before -= price_food_old;
        total_pay_hidden_before += price_food_new;
        $('#priceBefore\\['+x+'\\]').val(price_food_new);
        $('#totalPayHidden').val(total_pay_hidden_before);
        $('#totalPay').val(formatRupiah(parseInt(total_pay_hidden_before)));
    }
};
function removeField (z){
    var button = $('#buttonRemoveFood\\['+z+'\\]');
    var price_food_new = $('#orderFood\\['+z+'\\]').val();
    var total_pay_hidden = parseInt($('#totalPayHidden').val());
    if(price_food_new == null){
        total_pay_hidden -= 0;
    }else{
        total_pay_hidden -= parseInt(price_food_new);
    }
    $('#totalPayHidden').val(total_pay_hidden);
    $('#totalPay').val(formatRupiah(parseInt(total_pay_hidden)));
    button.parent().parent().parent().parent().parent().parent().remove();
};
function formatRupiah(uang){
    var bilangan = uang;
    var combine;
    
    var number_string = bilangan.toString(),
        sisa    = number_string.length % 3,
        rupiah  = number_string.substr(0, sisa),
        ribuan  = number_string.substr(sisa).match(/\d{3}/g);
            
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    combine = "Rp " + String(rupiah);
    return combine;
};