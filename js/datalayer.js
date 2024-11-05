/* push datalayer */
function pushWADataLayer(){
    dataLayer.push({
        'event':'click',
        'name':'WA button clicked',
    });
}

$('#vicente-btn-navbar').on('click',function(){
    dataLayer.push({
        'event':'click_navbar',
        'name':'vicente navbar click',
    });
});

/* set button events on whatsapp */
$('.whatsapp-btn').on('click',pushWADataLayer);
$('.whatsapp-btn-1').on('click',pushWADataLayer);
$('.whatsapp-float').on('click',pushWADataLayer);