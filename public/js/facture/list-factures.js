console.log("hello from list factures");
console.log(produits_factures);
console.log(produits_factures);
var nbProduit = 0;

// to get all products that are associated with the selected order form (bon de commande):
$(".btn_show_produits").click(function (e) {
    e.preventDefault();
    debugger
    let facture_id = jQuery(this).data('facture_id');
    let devie_id = jQuery(this).data('devie_id');
    // check if there's no hacking across html:
    if (isNaN(facture_id) || isNaN(devie_id)) {
        alert('Vous ne devez pas jouer sur les éléments HTML qui ne vous concernent pas.');
        return;
    }

    removeProductsFromTable(); // clear the table from products.
    // to find the product by invoice (facture) or by quotation (devis):
    if (devie_id) { // if the invoice is associated with a quotation
        produits_devies.forEach(produit => {
            if (produit.devie_id == devie_id) {
                addProduitToTable(produit);
            }
        });
    } else { // if the invoice isn't associated with a quotation
        produits_factures.forEach(produit => {
            if (produit.facture_id == facture_id) {
                addProduitToTable(produit);
            }
        });
    }
});

/**
 * Clear table products
 */
function removeProductsFromTable() {
    jQuery("#table-details-facture tbody tr").remove();
    jQuery('#prix_total_facture_HT').text(calculatePriceGlobal(jQuery('#table-details-facture tbody tr td:nth-child(7)')));
    jQuery('#prix_total_facture_TT').text((20 * Number(jQuery('#prix_total_facture_HT').text())) / 100 + Number(jQuery('#prix_total_facture_HT').text()));
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
    jQuery('#prix_total_facture_HT').text(calculatePriceGlobal(jQuery('#table-details-facture tbody tr td:nth-child(7)')));
    jQuery('#prix_total_facture_TT').text((20 * Number(jQuery('#prix_total_facture_HT').text())) / 100 + Number(jQuery('#prix_total_facture_HT').text()));
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
