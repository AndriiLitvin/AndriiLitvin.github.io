'use strict';

function loadMasonry() {

    var grid = document.querySelector('.grid');
    new Masonry(grid, {
        itemSelector: '.grid-item',
        columnWidth: '.grid-sizer',
        gutter: '.gutter-sizer',
    });

    var searchWords = ['cat', 'dog', 'pigs', 'sun', 'smile', 'egypt', 'sea', 'sky', 'tree', 'sand', 'space'];

    var searchWordIndex = Math.floor(Math.random() * (searchWords.length - 1));
    search(searchWords[searchWordIndex]);
    search_partner();

    function masonry_build(data) {
        var gridItems = document.getElementsByClassName('grid-item');
        for (var i = 0; i < gridItems.length; i++) {
            gridItems[i].style.backgroundImage = 'url(' + ((data.hits)[i].webformatURL) + ')';
            var itemText = gridItems[i].getElementsByClassName('item__text')[0];
            itemText.innerHTML = data.hits[i].tags.split(',')[0];
        }
    }

    function search_partner() {
        var searchPartnerButtonEl = document.getElementsByClassName('search-partners_button')[0];
        searchPartnerButtonEl.addEventListener('click', function (e) {
            e.preventDefault();
            var searchQuery = document.getElementById('search_query');
            search(searchQuery.value);
        });
    }


    function search(request) {

        if (window.XDomainRequest) {
            var xdr = new XDomainRequest();
            xdr.open("get", 'https://pixabay.com/api/');
            xdr.onload = function () {
                if (xmlhttp.status == 200) {
                    var response = xmlhttp.responseText;
                    var responseJson = JSON.parse(response);
                    if (responseJson.length == 0) {
                        console.log('pixabay не вернул ни одной картинки');
                        return;
                    }
                    else {
                        masonry_build(responseJson);
                    }
                }
            };
            setTimeout(function () {
                xdr.send('?key=5270170-c6e51883c4d17561ecf30e5fa&q=' + request + '&image_type=photo&min_width=260&per_page=7');
            }, 0);
        } else {
            var xmlhttp = new XMLHttpRequest();

            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == XMLHttpRequest.DONE) {
                    if (xmlhttp.status == 200) {
                        var response = xmlhttp.responseText;
                        var responseJson = JSON.parse(response);
                        if (responseJson.length == 0) {
                            console.log('pixabay не вернул ни одной картинки');
                            return;
                        }
                        else {
                            masonry_build(responseJson);
                        }
                    }
                    else if (xmlhttp.status == 400) {
                        console.log('There was an error 400');
                    }
                    else
                        console.log('something else other than 200 was returned');
                }
            }
        }

        xmlhttp.open('GET', 'https://pixabay.com/api/?key=5270170-c6e51883c4d17561ecf30e5fa&q=' + request + '&image_type=photo&min_width=260&per_page=7', true);
        xmlhttp.send();
    }
}


