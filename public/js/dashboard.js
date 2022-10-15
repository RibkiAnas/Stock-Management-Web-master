console.log("hello from dashboard");
var nbPersons = 0;

// to get clients with credit:
$("#btn_clients_with_credit").click(function (e) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') // add the CSRF token to the request.
        }
    });
    e.preventDefault();
    debugger
    var type = "GET";
    var ajax_url = '/dashboard/clients/credit';
    $.ajax({
        type: type,
        async: false,
        url: ajax_url,
        dataType: 'json',
        success: function (clients) {
            debugger
            removePersonsFromTable(); // clear the table from products.
            if (clients.length != 0) {
                // add products to the table product:
                clients.forEach(client => {
                    addPersonToTable(client, 'client');
                });
            } else {
                let tr = document.createElement('tr');
                let tdMessage = document.createElement('td');
                tdMessage.colSpan = 8;
                let message = document.createTextNode("Il y a aucun client");
                tdMessage.appendChild(message);
                tr.appendChild(tdMessage);
                jQuery('#tbl_tbody_persons').append(tr);
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
// to get suppliers (fournisseurs) with dette:
$("#btn_fournisseurs_with_dette").click(function (e) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') // add the CSRF token to the request.
        }
    });
    e.preventDefault();
    debugger
    var type = "GET";
    var ajax_url = '/dashboard/fournisseurs/dette';
    $.ajax({
        type: type,
        async: false,
        url: ajax_url,
        dataType: 'json',
        success: function (fournisseurs) {
            debugger
            removePersonsFromTable(); // clear the table from products.
            if (fournisseurs.length != 0) {
                // add products to the table product:
                fournisseurs.forEach(fournisseur => {
                    addPersonToTable(fournisseur, 'fournisseur');
                });
            } else {
                let tr = document.createElement('tr');
                let tdMessage = document.createElement('td');
                tdMessage.colSpan = 8;
                let message = document.createTextNode("Il y a aucun fournisseur");
                tdMessage.appendChild(message);
                tr.appendChild(tdMessage);
                jQuery('#tbl_tbody_persons').append(tr);
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
function removePersonsFromTable() {
    jQuery("table tbody tr").remove();
    nbPersons = 0;
}
/**
 * Insert new tr element that represent a product
 * @param person object of type person
 */
function addPersonToTable(person, person_type) {
    debugger
    let tr = document.createElement('tr');

    let tdnbPersons = document.createElement('td');
    tdnbPersons.classList.add('align-middle');
    let tdNomComplet = document.createElement('td');
    tdNomComplet.classList.add('align-middle');
    let tdTelephone = document.createElement('td');
    tdTelephone.classList.add('align-middle');
    let tdRC = document.createElement('td');
    tdRC.classList.add('align-middle');
    let tdNomSociete = document.createElement('td');
    tdNomSociete.classList.add('align-middle');
    let tdICE = document.createElement('td');
    tdICE.classList.add('align-middle');
    let tdCreditOrDette = document.createElement('td');
    tdCreditOrDette.classList.add('align-middle');
    let tdRegistration = document.createElement('td');
    tdRegistration.classList.add('align-middle');

    let nb = document.createTextNode(++nbPersons);
    tdnbPersons.appendChild(nb);

    let h2NomComplet = document.createElement('h2');
    h2NomComplet.classList.add('mb-1');
    h2NomComplet.textContent = person.nom_complet;
    tdNomComplet.appendChild(h2NomComplet);

    let telephone = document.createTextNode(person.telephone);
    tdTelephone.appendChild(telephone);

    let rc = document.createTextNode(person.rc);
    tdRC.appendChild(rc);

    let nomSociete = document.createTextNode(person.nom_societe);
    tdNomSociete.appendChild(nomSociete);

    let ice = document.createTextNode(person.ice);
    tdICE.appendChild(ice);

    let creditOrDette = document.createTextNode((person_type == 'client') ? person.credit : (person_type == 'fournisseur') ? person.dette : '');
    tdCreditOrDette.appendChild(creditOrDette);

    let registration = document.createTextNode(person.created_at);
    tdRegistration.appendChild(registration);

    tr.appendChild(tdnbPersons);
    tr.appendChild(tdNomComplet);
    tr.appendChild(tdTelephone);
    tr.appendChild(tdRC);
    tr.appendChild(tdNomSociete);
    tr.appendChild(tdICE);
    tr.appendChild(tdCreditOrDette);
    tr.appendChild(tdRegistration);

    jQuery('#tbl_tbody_persons').append(tr);
}
