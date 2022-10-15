console.log("hello from edit bon");
var nbProduit = 0;
var produitToModify = null;
var selectedTr = null;
$(document).ready(function () {
    $('.livesearchfournisseurs').select2({
        placeholder: 'Select Fournisseur',
        ajax: {
            url: '/ajax-autocomplete-search-fournisseur',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.nom_complet,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
});

$(document).ready(function () {
    nbProduit = jQuery("table:nth-of-type(1) tbody tr").length; // get number of products.
    console.log(produits);

    // to Add new product that will be associated with this order form(bon de commande):
    $("#btn_add_produit").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') // add the CSRF token to the request.
            }
        });
        e.preventDefault();
        var produit_data = {
            produit_libelle: jQuery('#produit_libelle').val(),
            produit_ref: jQuery('#produit_ref').val(),
            produit_price: jQuery('#produit_price').val(),
            produit_qte: jQuery('#produit_qte').val(),
            produit_price_buy: jQuery('#produit_price_buy').val(),
        };
        var type = "POST";
        var ajax_url = '/produit';
        $.ajax({
            type: type,
            async: false,
            url: ajax_url,
            data: produit_data,
            dataType: 'json',
            success: function (produit) {
                // this condition to ckech if there's a tr that indicate no product exists with this order form:
                if (produits.length == 0) {
                    removeTrIndicationMessage();
                }
                produits.push(produit);
                addProduitToTable(produit, 'add');
            },
            error: function (errorResp) {
                let errors = JSON.parse(errorResp.responseText).errors; // get the errors validation.
                console.log(errors);
                for (const error in errors) { // loop through each error
                    for (const errorMsg of errors[error]) { // loop through each error's messages.
                        console.log(errorMsg);
                    }
                }
            }
        });
    });
    // to update a product that will be associated with this order form(bon de commande):
    $("#btn_update_produit").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') // add the CSRF token to the request.
            }
        });
        e.preventDefault();
        debugger
        let produit_id = jQuery(this).data('produit_id');
        var produit_data = {
            produit_libelle: jQuery('#produit_libelle').val(),
            produit_ref: jQuery('#produit_ref').val(),
            produit_price: jQuery('#produit_price').val(),
            produit_qte: jQuery('#produit_qte').val(),
            produit_price_buy: jQuery('#produit_price_buy').val(),
        };
        var type = "PUT";
        var ajax_url = '/produit/' + produit_id;
        $.ajax({
            type: type,
            async: false,
            url: ajax_url,
            data: produit_data,
            dataType: 'json',
            success: function (produit) {
                debugger
                let produit_index = $.inArray(produitToModify, produits);
                Object.assign(produits[produit_index], produit); // update the product in the array with the new values.
                addProduitToTable(produit, 'update'); // to change infos of the modified product.
                backToInit();
            },
            error: function (errorResp) {
                let errors = JSON.parse(errorResp.responseText).errors; // get the errors validation.
                console.log(errors);
                for (const error in errors) { // loop through each error (for objects).
                    for (const errorMsg of errors[error]) { // loop through each error's messages (for arrays).
                        console.log(errorMsg);
                    }
                }
            }
        });
    });
    $(".btn_edit_produit").click(function (e) {
        prepareProduitToModify(e, jQuery(this));
    });
    $(".btn_delete_produit").click(function (e) {
        deleteProduit(e, jQuery(this));
    })
});
/**
 * Get product to be modified and fill form update's inputs
 * @param e
 * @param sender
 */
function prepareProduitToModify(e, sender) {
    e.preventDefault();
    debugger;
    let produit_id = sender.data('produit_id');
    // to find the product by id:
    produitToModify = jQuery.grep(produits, function (prd, index) {
        return prd.id == produit_id;
    })[0];

    // fill inputs with product's data to modify:
    jQuery('#produit_libelle').val(produitToModify.libelle);
    jQuery('#produit_ref').val(produitToModify.ref);
    jQuery('#produit_price').val(produitToModify.price);
    jQuery('#produit_price_buy').val(produitToModify.price_buy);
    jQuery('#produit_qte').val(produitToModify.qte);

    jQuery('#produit_libelle').focus(); // make focus on the libelle input.

    jQuery("#btn_update_produit").toggleClass('d-none');

    jQuery("#btn_add_produit").toggleClass('d-none');

    jQuery("#btn_update_produit").data('produit_id', produit_id); // store product id in this button's dataset.

    selectedTr = sender.parents("tr");

    jQuery("#frm_produit").attr('action', '/produit/' + produit_id);
}
/**
 * Delete tr that indicate that there's no product with this order form
 */
function removeTrIndicationMessage() {
    jQuery("#trIndicator").remove();
}
/**
 * This will render an adding form
 */
function backToInit() {
    jQuery("#btn_update_produit").css('visibility', 'collapse');
    jQuery("#btn_add_produit").css('visibility', 'visible');

    jQuery('#produit_ref').val("");
    jQuery('#produit_libelle').val("");
    jQuery('#produit_price').val("");
    jQuery('#produit_price_buy').val("");
    jQuery('#produit_qte').val("");

    jQuery("#frm_produit").attr('action', '/produit');

    selectedTr = null;
}
/**
 * Insert new tr element that represent a product
 * @param produit object of type Produit
 */
function addProduitToTable(produit, action) {
    debugger
    let tr = document.createElement('tr');

    let tdNbProduit = document.createElement('td');
    let tdRefProduit = document.createElement('td');
    let tdLibelleProduit = document.createElement('td');
    let tdPrixBuyProduit = document.createElement('td');
    let tdPrixProduit = document.createElement('td');
    let tdQteProduit = document.createElement('td');
    let tdActionProduit = document.createElement('td');

    let nb = document.createTextNode((action == 'add') ? ++nbProduit : selectedTr.children("td:first-child").text());
    tdNbProduit.appendChild(nb);

    let ref = document.createTextNode(produit.ref);
    tdRefProduit.appendChild(ref);

    let libelle = document.createTextNode(produit.libelle);
    tdLibelleProduit.appendChild(libelle);

    let price_buy = document.createTextNode(produit.price_buy);
    tdPrixBuyProduit.appendChild(price_buy);

    let price = document.createTextNode(produit.price);
    tdPrixProduit.appendChild(price);

    let qte = document.createTextNode(produit.qte);
    tdQteProduit.appendChild(qte);

    let buttonEditproduit = document.createElement('button');
    buttonEditproduit.classList.add('btn_edit_produit');

    buttonEditproduit.dataset.produit_id = produit.id;
    buttonEditproduit.innerHTML = '<i class="bi bi-pencil-square"></i>';
    buttonEditproduit.classList = 'btn btn-success btn-sm me-1';
    // this function will fill the inputs with the product to modify:
    buttonEditproduit.onclick = function (e) {
        prepareProduitToModify(e, jQuery(this));
    }
    tdActionProduit.appendChild(buttonEditproduit);

    let buttonDeleteproduit = document.createElement('button');
    buttonDeleteproduit.classList.add('btn_delete_produit');
    buttonDeleteproduit.dataset.produit_id = produit.id;
    buttonDeleteproduit.innerHTML = '<i class="bi bi-trash3"></i>';
    buttonDeleteproduit.classList = 'btn btn-danger btn-sm';
    buttonDeleteproduit.onclick = function (e) {
        deleteProduit(e, jQuery(this));
    }
    tdActionProduit.appendChild(buttonDeleteproduit);

    tr.appendChild(tdNbProduit);
    tr.appendChild(tdRefProduit);
    tr.appendChild(tdLibelleProduit);
    tr.appendChild(tdPrixBuyProduit);
    tr.appendChild(tdPrixProduit);
    tr.appendChild(tdQteProduit);
    tr.appendChild(tdActionProduit);
    if (action == 'add') {
        jQuery('#tbl_tbody_produits').append(tr);

        jQuery('#produit_ref').val("");
        jQuery('#produit_libelle').val("");
        jQuery('#produit_price').val("");
        jQuery('#produit_price_buy').val("");
        jQuery('#produit_qte').val("");

        let inpProduitsIds = jQuery('#produits_ids');
        inpProduitsIds.val((inpProduitsIds.val() == "") ? inpProduitsIds.val() + produit.id : inpProduitsIds.val() + "," + produit.id); // save ids of newly created products in order to associate them with this order form.

        alert('produit bien ajouté');
    } else if (action == 'update') {
        let nbTr = Number(jQuery("table tbody tr").length);
        if (nbTr != 1) { // if there's + than one row
            if (selectedTr[0].rowIndex == 1) {
                let nextTr = selectedTr.next();
                nextTr.before(tr); // insert tr with updated product's data in the same place.
            } else {
                let prevTr = selectedTr.prev();
                prevTr.after(tr); // insert tr with updated product's data in the same place.
            }
        } else {
            jQuery('#tbl_tbody_produits').append(tr);
        }
        selectedTr.remove(); // remove the old tr.

        alert('produit bien modifié');
    }

    jQuery('#produit_libelle').focus();
}
/**
 * Delete product
 */
function deleteProduit(e, sender) {
    e.preventDefault();
    debugger;

    selectedTr = sender.parents("tr");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') // add the CSRF token to the request.
        }
    });

    let produit_id = sender.data('produit_id');

    var type = "DELETE";
    var ajax_url = '/produit/' + produit_id;
    $.ajax({
        type: type,
        async: false,
        url: ajax_url,
        dataType: 'json',
        success: function (produit) {
            debugger
            // remove from products array:
            produits = jQuery.grep(produits, function (prd, index) {
                return prd.id != produit.id;
            });

            // adjust the number of products:
            nbProduit = Number(selectedTr.children("td:first-child").text());
            nbTr = Number(jQuery("table tbody tr").length);
            // this condition for the case when the user remove all products from the order form.
            if (nbTr !== 1) {
                // this condition to handle the case when the user remove the last product from the order form.
                if (nbProduit < nbTr) {
                    for (let i = nbProduit + 1; i <= nbTr; i++) {
                        jQuery("table tbody tr:nth-child(" + i + ")").children("td:first-child").text((i < nbTr) ? nbProduit++ : nbProduit);
                    }
                } else {
                    nbProduit--;
                }
            } else {
                nbProduit = 0;
            }

            let inpProduitsIds = jQuery('#produits_ids');
            let newProduitsIds = inpProduitsIds.val().split(',');
            newProduitsIds = jQuery.grep(newProduitsIds, function (id, index) {
                return id != produit.id;
            });
            inpProduitsIds.val(newProduitsIds.join());

            selectedTr.remove();
            selectedTr = null;
        },
        error: function (errorResp) {
            let errors = JSON.parse(errorResp.responseText).errors; // get the errors validation.
            console.log(errors);
            for (const error in errors) { // loop through each error (for objects).
                for (const errorMsg of errors[error]) { // loop through each error's messages (for arrays).
                    console.log(errorMsg);
                }
            }
        }
    });
}
