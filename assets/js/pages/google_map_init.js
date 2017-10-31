/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



function initMap() {
    var uluru = {lat: -33.910212, lng: 18.609219};
    var map = new google.maps.Map(document.getElementById('patients_map'), {
        zoom: 4,
        center: uluru
    });
    var marker = new google.maps.Marker({
        position: uluru,
        map: map
    });
}
