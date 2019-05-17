$(document).ready(function(){

    var $collectionHolder;
    var $addItemButton = $('<button type= "button" class="add_item_link">Ajouter un prix </button>');
    var $newPrice = $('<div></div>').append($addItemButton);

    $collectionHolder = $('#assoc_prices');
    $collectionHolder.append($newPrice);

    $collectionHolder.find('.prices').each(function(){
        addPriceFormDelete($(this));
    });
    $collectionHolder.data('index', $collectionHolder.find('.prices').length);
    $addItemButton.on('click',function(e){
        addPriceFrom($collectionHolder, $newPrice);
    });
});

function addPriceFormDelete(arg){
    var $removeFormButton = $('<button type="button">Supprimer le prix</button>');
    arg.append($removeFormButton);
    $removeFormButton.on('click', function(e){
        arg.remove();
    });
}

function addPriceFrom($collectionHolder, $newItemLi) {
    var prototype = $collectionHolder.data('prototype');
    var index = $collectionHolder.data('index');
    var newForm = prototype;
    newForm = newForm.replace(/__name__/g, index);
    $collectionHolder.data('index', index + 1);
    var $newFormLi = $('<div></div>').append(newForm);
    $newItemLi.before($newFormLi);
    addPriceFormDelete($newFormLi);
}
