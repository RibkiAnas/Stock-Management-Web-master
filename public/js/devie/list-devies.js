console.log("hello from list devies");
console.log(produits);
var nbProduit = 0;

$(document).ready(function(){
    jQuery("#frm_conversion_to_invoice").css("visibility", "collapse"); // hide the popup at the start.
})
// to get all products that are associated with the selected order form (bon de commande):
$(".btn_show_produits").click(function () {
    let devie_id = jQuery(this).data('devie_id');
    // check if there's no hacking across html:
    if (isNaN(devie_id)) {
        alert('Vous ne devez pas jouer sur les éléments HTML qui ne vous concernent pas.');
        return;
    }
    debugger;
    removeProductsFromTable(); // clear the table from products.
    // to find the product by id:
    produits.forEach(produit => {
        if (produit.devie_id == devie_id) {
            addProduitToTable(produit);
        }
    });
});
// convert quotation (devis) to invoice (facture):
// $(".btn_convert_to_invoice").click(function (e) {
//     e.preventDefault();
//     debugger
//     let devie_id = jQuery(this).data('devie_id');
//     // check if there's no hacking across html:
//     if (isNaN(devie_id)) {
//         alert('Vous ne devez pas jouer sur les éléments HTML qui ne vous concernent pas.');
//         return;
//     }
//     jQuery("#frm_conversion_to_invoice").css("visibility", "visible");
//     jQuery("#devie").val(devie_id);

// });

/**
 * Clear table products
 */
function removeProductsFromTable() {
    jQuery("#table-details-devis tbody tr").remove();
    jQuery('#prix_total_devie_HT').text(calculatePriceGlobal(jQuery('#table-details-devis tbody tr td:nth-child(7)')));
    jQuery('#prix_total_devie_TT').text((20 * Number(jQuery('#prix_total_devie_HT').text())) / 100 + Number(jQuery('#prix_total_devie_HT').text()));
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
    let tdPrixProduit = document.createElement('td');
    let tdQteProduit = document.createElement('td');
    let tdQte_clientProduit = document.createElement('td');
    let tdPrice_tProduit = document.createElement('td');

    let nb = document.createTextNode(++nbProduit);
    tdNbProduit.appendChild(nb);

    let ref = document.createTextNode(produit.ref);
    tdRefProduit.appendChild(ref);

    let libelle = document.createTextNode(produit.libelle);
    tdLibelleProduit.appendChild(libelle);

    let price = document.createTextNode(produit.price);
    tdPrixProduit.appendChild(price);

    let qte = document.createTextNode(produit.qte);
    tdQteProduit.appendChild(qte);

    let qte_client = document.createTextNode(produit.quantity);
    tdQte_clientProduit.appendChild(qte_client);

    let price_t = document.createTextNode(produit.quantity * produit.price);
    tdPrice_tProduit.appendChild(price_t);

    tr.appendChild(tdNbProduit);
    tr.appendChild(tdRefProduit);
    tr.appendChild(tdLibelleProduit);
    tr.appendChild(tdPrixProduit);
    tr.appendChild(tdQteProduit);
    tr.appendChild(tdQte_clientProduit);
    tr.appendChild(tdPrice_tProduit);

    jQuery('#tbl_tbody_produits').append(tr);

    // calculate the price of the quotation (devis):
    jQuery('#prix_total_devie_HT').text(calculatePriceGlobal(jQuery('#table-details-devis tbody tr td:nth-child(7)')));
    jQuery('#prix_total_devie_TT').text((20 * Number(jQuery('#prix_total_devie_HT').text())) / 100 + Number(jQuery('#prix_total_devie_HT').text()));
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
