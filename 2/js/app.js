'use strict';

// Init receipts array in the localStorage
if (!localStorage.getItem('receipts')) {
    localStorage.setItem('receipts',JSON.stringify([]));
}
var receiptsManager = new ReceiptsManager(localStorage.getItem('receipts'));

$(function(){

    // The default action is the list
    initList();

    // Init left menu action
    $('#list').on('click',initList);

    // Init left menu action
    $('#create').on('click',createReceipt);

    // Init left menu action
    $('#summarize').on('click',summarize);

    // Open the edit window
    $('#content').on('click','.edit',function(){
        var id = $(this).attr('data-id');
        var receipt = receiptsManager.find(id);

        $('#date').val(receipt.date.format('YYYY-MM-DD'));
        $('#name').val(receipt.name);
        $('#amount').val(receipt.amount);
        $('#action').attr('data-id', id);
        $("#receipt").modal('show');
    });

    // Remove a receipt
    $('#content').on('click','.remove',function(){
        var id = $(this).attr('data-id');
        receiptsManager.remove(id);
        alert('Ticket supprimé avec succès');
        initList();
    });


    // Creating or editing a receipt
    $('#action').on('click',function(){
        let id = parseInt($(this).attr('data-id'));

        // Validate fields
        let date = moment($('#date').val());
        let name = $('#name').val();
        let amount = parseInt($('#amount').val(),10);

        // Fields are ok
        if(date.isValid() && name.trim() !== "" && amount > 0)
        {
            // Adding a new receipt
            if(id === -1)
            {
                if(receiptsManager.add(new Receipt(date,name,amount)))
                {
                    alert('Ticket ajouté avec succès');
                    resetModal();
                }
                else
                {
                    alert('Un ticket existe déjà à cette date');
                }
            }
            // Editing a receipt
            else
            {
                if(receiptsManager.edit(id,new Receipt(date,name,amount)))
                {
                    alert('Ticket édité avec succès');
                    resetModal();
                }
                else
                {
                    alert('Un ticket existe déjà à cette date');
                }
            }

            // Load the list again
            initList();
        }
    });

});

// Init receipts list
function initList(){

    $('#content').empty();

    // Show receipts list order by
    var receipts = receiptsManager.getRecent();
    if(receipts.length > 0 )
    {
        for(var r in receipts)
        {
            $('#content').append('<tr data-id="'+r+'">' +
                '<td>'+receipts[r].date.format('DD/MM/YYYY')+'</td>' +
                '<td>'+receipts[r].name+'</td>' +
                '<td>' + receipts[r].amount + ' &euro;</td>' +
                '<td><button class="btn btn-sm btn-primary edit" data-id="'+r+'">Editer</button> <button class="btn btn-sm btn-danger remove" data-id="'+r+'">Supprimer</button> </td>' +
                '</tr>')
        }
    }
    else
    {
        $('#content').append('<tr><td colspan="4" class="text-center"><em>Aucun ticket</em></td></tr>')
    }
}

// Init creating receipt
function createReceipt()
{
    // Action mode
    resetModal();
    $("#receipt").modal('show');
}

// Reset modal
function resetModal(){
    $('#date').val('');
    $('#name').val('');
    $('#amount').val('');
    $('#action').attr('data-id', -1);
    $("#receipt").modal('hide');
}

// Init summarize
function summarize(){
    $('#summary_table').empty();

    var total_month = receiptsManager.getTotalByMonth();
    var total = 0;
    for(var date in total_month)
    {
        $('#summary_table').append('<tr><td>'+ date +'</td><td>'+ total_month[date] +' &euro;</td></tr>');
        total += total_month[date];
    }
    $('#summary_table').append('<tr><td><strong>Total</strong></td><td><strong>'+ total +' &euro;</strong></td></tr>');
    $('#summary').modal('show');

}