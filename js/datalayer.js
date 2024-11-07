/* push datalayer */
function pushWADataLayer(){
    dataLayer.push({
        'event':'click-wa',
        'name':'WA button clickod - body',
        'location':'body',
    });
}

$('#vicente-btn-navbar').on('click',function(){
    dataLayer.push({
        'event':'click',
        'name':'navbar click - vicente',
    });
});

/* set button events on whatsapp */
$('.whatsapp-btn').on('click',pushWADataLayer);
$('.whatsapp-btn-1').on('click',pushWADataLayer);

$('.whatsapp-float').on('click',function(){
    dataLayer.push({
        'event':'click-wa',
        'name':'WA button click',
        'location':'float',
    });
});