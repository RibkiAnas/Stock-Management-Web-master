console.log("hello from list bons");
var nbProduit = 0;

// to get all products that are associated with the selected order form (bon de commande):
$(".btn_show_produits").click(function (e) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') // add the CSRF token to the request.
        }
    });
    e.preventDefault();
    debugger
    let bon_commande_id = jQuery(this).data('bon_commande_id');
    // check if there's no hacking across html:
    if (isNaN(bon_commande_id)) {
        alert('Vous ne devez pas jouer sur les éléments HTML qui ne vous concernent pas.');
        return;
    }

    var type = "GET";
    var ajax_url = '/produit/byBonCommande/' + bon_commande_id;
    $.ajax({
        type: type,
        async: false,
        url: ajax_url,
        dataType: 'json',
        success: function (produits) {
            debugger
            removeProductsFromTable(); // clear the table from products.
            if (produits.length != 0) {
                // add products to the table product:
                produits.forEach(produit => {
                    addProduitToTable(produit);
                });
            } else {
                let tr = document.createElement('tr');
                let tdMessage = document.createElement('td');
                tdMessage.colSpan = 4;
                let message = document.createTextNode("Il y a aucun produit avec ce bon de commande.");
                tdMessage.appendChild(message);
                tr.appendChild(tdMessage);
                jQuery('#tbl_tbody_produits').append(tr);
            }
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

/**
 * Clear table products
 */
function removeProductsFromTable() {
    jQuery("#table-details-bon tbody tr").remove();
    nbProduit = 0;
}
/**
 * Insert new tr element that represent a product
 * @param produit object of type Produit
 */
function addProduitToTable(produit) {
    debugger
    let tr = document.createElement('tr');

    let tdNbProduit = document.createElement('td');
    let tdRefProduit = document.createElement('td');
    let tdLibelleProduit = document.createElement('td');
    let tdPrixBuyProduit = document.createElement('td');
    let tdPrixProduit = document.createElement('td');
    let tdQteProduit = document.createElement('td');

    let nb = document.createTextNode(++nbProduit);
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

    tr.appendChild(tdNbProduit);
    tr.appendChild(tdRefProduit);
    tr.appendChild(tdLibelleProduit);
    tr.appendChild(tdPrixBuyProduit);
    tr.appendChild(tdPrixProduit);
    tr.appendChild(tdQteProduit);

    jQuery('#tbl_tbody_produits').append(tr);
}
