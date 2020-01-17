//------------------------------collapsible
var coll = document.getElementsByClassName("collapsible");
var i;
// datePicker();
for (i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function () {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.maxHeight) {
            content.style.maxHeight = null;
        } else {
            content.style.maxHeight = "max-content";
        }
    });
}


//------------------------------add new row
function addRow(ID) {

    var table = document.getElementById('dataTable'+ID);

    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);

    var colCount = table.rows[0].cells.length;
    row.id = "product-"+ID+"-row-"+rowCount;
    for (var i = 0; i < colCount; i++) {

        var newcell = row.insertCell(i);
        switch (table.rows[0].cells[i].innerHTML) {
            case "Import Date":
                newcell.innerHTML = '<input class="input-import-date" name="import-date[]" type="text"/>';
                break;
            case "Out Date":
                newcell.innerHTML = '<input class="input-out-date" name="out-date[]" type="text"/>';
                break;
            case "Qty":
                newcell.innerHTML = '<input name="qty[]" type="number"/>';
                break;
            case "Delete":
                newcell.innerHTML = '<input type="button" value="x" class="btn-icon" onclick="deleteRow('+ID+','+rowCount+')"/>';
                break;
            case "Product ID":
                newcell.style.display = 'none';
                newcell.innerHTML = '<input type="hidden" name="product-id[]" value="'+ID+'"/>';
                break;
        }
    }
    // datePicker();
}

//------------------------------delete row
function deleteRow(id_product,index) {
    var row = document.getElementById("product-"+id_product+"-row-"+index);
    row.parentNode.removeChild(row);
    // var table = row.parentNode;
    // while (table && table.tagName != 'TABLE')
    //     table = table.parentNode;
    // if (!table)
    //     return;
    // table.deleteRow(row.rowIndex);
};

//------------------------------datePicker
function datePicker() {

    $(".input-import-date").datepicker(
        {
            dateFormat: 'dd-mm-yy',
            gotoCurrent: true,
            hideIfNoPrevNext: true,
            minDate: new Date(),
            maxDate: null
        });
    $(".input-out-date").datepicker({
        dateFormat: 'dd-mm-yy',
        gotoCurrent: true,
        hideIfNoPrevNext: true,
        minDate: new Date(),
        maxDate: null
    });
};


// before save data
// $("#publish").on('click', function (e) {
//     e.preventDefault(e);
//     var data = [];
//     $(".input-import-date").each(function (i, date) {
//         data[i]['import-date'] = date.value
//     });
// });
