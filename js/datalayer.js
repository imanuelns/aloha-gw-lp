/* push datalayer */
function pushWADataLayer(){
    dataLayer.push({
        'event':'click',
        'name':'WA button clicked',
    });
}

/* set button events on whatsapp */
$('.whatsapp-btn').on('click',pushWADataLayer);
$('.whatsapp-btn-1').on('click',pushWADataLayer);