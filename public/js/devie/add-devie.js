console.log('here we go');
// console.log(bons);
console.log(produits);
var nbProduit = 0;
var produitToOperate = null;
var selectedTr = null;

$(document).ready(function () {
    $('.livesearchclient').select2({
        placeholder: 'Select Client',
        ajax: {
            url: '/ajax-autocomplete-search',
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
    $('.livesearchproduit').select2({
        placeholder: 'Select Produit',
        ajax: {
            url: '/ajax-autocomplete-search-produit',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.ref,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
    // display all info for the first product when the page has been successfully loading:
    // if (bons.length != 0) {
    //     $("#list_produits").trigger('change');
    // }
})
// fill the product form by the selected product's info:
$("#list_produits").change(function (e) {
    e.preventDefault();
    let produit_id = jQuery(this).val();
    // check if there's no hacking across html:
    if (isNaN(produit_id)) {
        alert('Vous ne devez pas jouer sur les éléments HTML qui ne vous concernent pas.');
        return;
    }

    // to find the product by id:
    // bons.forEach(bon => {
    //     bon.produits.forEach(prd => {
    //         if (prd.id == produit_id) {
    //             produitToOperate = prd;
    //         }
    //     })
    // });
    produits.forEach(prd => {
        if (prd.id == produit_id) {
            produitToOperate = prd;
        }
    });

    // fill inputs with product's data:
    //jQuery('#produit_ref').val(produitToOperate.ref);
    jQuery('#produit_price').val(produitToOperate.price);
    if ($("#produit_qte").val() != "") {
        $("#produit_qte").trigger('change');
    } else {
        jQuery('#produit_price_total').val("");
    }
    //jQuery('#produit_qte_stock').val(produitToOperate.qte);
    //jQuery('#bon_commande').val(jQuery(this)[0].selectedOptions[0].dataset.bon_commande_num_fournisseur_nom);
});
// calculate the global price by the selected quantity:
$("#produit_qte").change(function (e) {
    e.preventDefault();
    let qte = jQuery(this).val();
    // check if there's no hacking across html:
    if (isNaN(qte)) {
        alert('Veuillez donner une valeur numérique valide.');
        return;
    }

    jQuery('#produit_price_total').val(Number(jQuery('#produit_price').val()) * Number(qte));
});
// to add the selected product with this quotation (devie):
$("#btn_add_produit").click(function (e) {
    e.preventDefault();
    addProduitToTable(produitToOperate, 'add');
});
// to update a product that will be associated with this :
$("#btn_update_produit").click(function (e) {
    e.preventDefault();
    let produit_id = jQuery(this).data('produit_id');
    produits.forEach(prd => {
        if (prd.id == produit_id) {
            produitToOperate = prd;
        }
    });
    addProduitToTable(produitToOperate, 'update'); // to change infos of the modified product.
    backToInit();
});
/**
 * Insert new tr element that represent a product
 * @param produit object of type Produit
 */
function addProduitToTable(produit, action) {
    let tr = document.createElement('tr');

    let tdNbProduit = document.createElement('td');
    let tdRefProduit = document.createElement('td');
    let tdLibelleProduit = document.createElement('td');
    let tdPrixProduit = document.createElement('td');
    let tdQteProduit = document.createElement('td');
    let tdQte_clientProduit = document.createElement('td');
    let tdPrice_tProduit = document.createElement('td');
    let tdActionProduit = document.createElement('td');

    let nb = document.createTextNode((action == 'add') ? ++nbProduit : selectedTr.children("td:first-child").text());
    tdNbProduit.appendChild(nb);

    let ref = document.createTextNode(produit.ref);
    tdRefProduit.appendChild(ref);

    let libelle = document.createTextNode(produit.libelle);
    tdLibelleProduit.appendChild(libelle);

    let price = document.createTextNode(produit.price);
    tdPrixProduit.appendChild(price);

    let qte = document.createTextNode(produit.qte);
    tdQteProduit.appendChild(qte);

    let qte_client = document.createTextNode(jQuery('#produit_qte').val());
    tdQte_clientProduit.appendChild(qte_client);

    let price_t = document.createTextNode(jQuery('#produit_price_total').val());
    tdPrice_tProduit.appendChild(price_t);

    let buttonEditproduit = document.createElement('button');
    buttonEditproduit.id = 'btn_edit_produit';
    buttonEditproduit.dataset.produit_id = produit.id;
    buttonEditproduit.innerHTML = '<i class="bi bi-pencil-square"></i>';
    buttonEditproduit.classList = 'btn btn-success btn-sm me-1';
    // this function will fill the inputs with the product to modify:
    buttonEditproduit.onclick = function (e) {
        e.preventDefault();
        selectedTr = jQuery(this).parents("tr");

        // fill inputs with product's data to modify:
        let produit_id = this.dataset.produit_id;
        $("#list_produits").val(produit_id).change();
        jQuery('#produit_qte').val(selectedTr.children("td:nth-child(6)").text());
        jQuery('#produit_price_total').val(selectedTr.children("td:nth-child(7)").text());

        jQuery('#produit_qte').focus(); // make focus on the libelle input.

        jQuery("#btn_update_produit").toggleClass('d-none');

        jQuery("#btn_add_produit").toggleClass('d-none');

        jQuery("#btn_update_produit").data('produit_id', produit_id); // store product id in this button's dataset.
    }
    tdActionProduit.appendChild(buttonEditproduit);

    let buttonDeleteproduit = document.createElement('button');
    buttonDeleteproduit.id = 'btn_Delete_produit';
    buttonDeleteproduit.dataset.produit_id = produit.id;
    buttonDeleteproduit.innerHTML = '<i class="bi bi-trash3"></i>';
    buttonDeleteproduit.classList = 'btn btn-danger btn-sm';
    buttonDeleteproduit.onclick = function (e) {
        e.preventDefault();

        selectedTr = jQuery(this).parents("tr");

        deleteProduit(jQuery(this));

        jQuery('#prix_total_devie_HT').text(calculatePriceGlobal(jQuery('table tbody tr td:nth-child(7)')));
        jQuery('#prix_total_devie_TT').text((20 * Number(jQuery('#prix_total_devie_HT').text())) / 100 + Number(jQuery('#prix_total_devie_HT').text()));
    }
    tdActionProduit.appendChild(buttonDeleteproduit);

    tr.appendChild(tdNbProduit);
    tr.appendChild(tdRefProduit);
    tr.appendChild(tdLibelleProduit);
    tr.appendChild(tdPrixProduit);
    tr.appendChild(tdQteProduit);
    tr.appendChild(tdQte_clientProduit);
    tr.appendChild(tdPrice_tProduit);
    tr.appendChild(tdActionProduit);
    if (action == 'add') {
        jQuery('#tbl_tbody_produits').append(tr);

        let inpProduitsIds = jQuery('#produits_ids');
        inpProduitsIds.val((inpProduitsIds.val() == "") ? inpProduitsIds.val() + produit.id : inpProduitsIds.val() + "," + produit.id); // save ids of newly created products in order to associate them with this order form.

        let inpQuantitiesValues = jQuery('#quantities_values');
        inpQuantitiesValues.val((inpQuantitiesValues.val() == "") ? inpQuantitiesValues.val() + jQuery('#produit_qte').val() : inpQuantitiesValues.val() + "," + jQuery('#produit_qte').val()); // save quantities of products which are associated with this quotation (devie).

        jQuery('#produit_qte').val("");
        jQuery('#produit_price_total').val("");

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

        // update quantities products:
        debugger
        let indexProduitId = $.inArray(produit.id.toString(), jQuery('#produits_ids').val().split(',')); // It will be used to extract the quantity of the removed product
        let inpQuantitiesValues = jQuery('#quantities_values');
        let newQuantitiesIds = inpQuantitiesValues.val().split(',');
        newQuantitiesIds[indexProduitId] = jQuery('#produit_qte').val();
        inpQuantitiesValues.val(newQuantitiesIds.join());


        alert('produit bien modifié');
    }

    // calculate the price of the quotation (devis):
    jQuery('#prix_total_devie_HT').text(calculatePriceGlobal(jQuery('table tbody tr td:nth-child(7)')));
    jQuery('#prix_total_devie_TT').text((20 * Number(jQuery('#prix_total_devie_HT').text())) / 100 + Number(jQuery('#prix_total_devie_HT').text()));
}
/**
 * Delete product
 */
function deleteProduit(sender) {
    let produit_id = sender.data('produit_id');

    // adjust the number of products:
    nbProduit = Number(selectedTr.children("td:first-child").text());
    let nbTr = Number(jQuery("table tbody tr").length);
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
    let indexProduitId = $.inArray(produit_id.toString(), newProduitsIds); // It will be used to extract the quantity of the removed product
    newProduitsIds = jQuery.grep(newProduitsIds, function (id, index) {
        return id != produit_id;
    });
    inpProduitsIds.val(newProduitsIds.join());

    let inpQuantitiesValues = jQuery('#quantities_values');
    let newQuantitiesIds = inpQuantitiesValues.val().split(',');
    newQuantitiesIds = jQuery.grep(newQuantitiesIds, function (quantity, index) {
        return index != indexProduitId;
    });
    inpQuantitiesValues.val(newQuantitiesIds.join());

    selectedTr.remove();
    selectedTr = null;
}
/**
 * This will render an adding form
 */
function backToInit() {
    jQuery("#btn_update_produit").toggleClass('d-none');
    jQuery("#btn_add_produit").toggleClass('d-none');


    jQuery('#produit_qte').val("");
    jQuery('#produit_price_total').val("");

    selectedTr = null;
}
/**
 * Calculate the global price
 * @param total Previously returned value
 * @param value The item value
 * @param index The item index
 * @param array The array itself
 * @returns The sum of the elements content
 */
function calculatePriceGlobal(prices) {
    let priceGlobal = 0
    for (let i = 0; i < prices.length; i++) {
        let price = Number(prices[i].textContent);
        priceGlobal += price;
    }
    return priceGlobal;
}
