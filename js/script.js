$('#different-city').click(function() {
    let city = prompt("Please put name of city");
    if(city == null || city == " ")
    {
        return;
    }
    let params = new URLSearchParams({
        'city-name': city,
    });

    window.location.href = window.location.pathname + '?' + params.toString();
})