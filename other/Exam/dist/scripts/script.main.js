'use strict';

window.onload = function () {

   var anchors = document.querySelectorAll('a');
   for (var i = 0; i < anchors.length; i++) {
      anchors[i].onclick = function () {
         return false;
      };
   }

   /*          Slider         */

   var sliders = document.querySelectorAll('.slider');

   for (var _i = 0; _i < sliders.length; _i++) {
      var arrowR = document.createElement('p');
      var arrowL = document.createElement('p');
      arrowR.classList.add('slider__arrowR');
      arrowL.classList.add('slider__arrowL');

      sliders[_i].appendChild(arrowL);
      sliders[_i].appendChild(arrowR);

      new Slider(sliders[_i], _i + 1);
   }

   function Slider(sliderObj, folderNum) {
      var self = this;
      this.currentValue = 1;
      this.list = sliderObj.querySelector('ul');
      this.sliderLength = sliderObj.querySelectorAll('ul li').length;
      this.itemWidth = 300;
      this.currentPos = 0;

      calculateWidth();
      initImages();
      leftBtn();
      rightBtn();

      function initImages() {
         var dist = 'dist/images/sliders/slider' + folderNum + '/';

         var items = self.list.querySelectorAll('li');
         for (var _i2 = 0; _i2 < items.length; _i2++) {
            var imgPath = dist + ('howIt' + folderNum + '.' + (_i2 + 1) + '.png');
            items[_i2].style.backgroundImage = 'url(' + imgPath + ')';
         }
      }

      function calculateWidth() {
         var listWidth = self.sliderLength * self.itemWidth;
         self.list.style.width = listWidth + 'px';
      }

      function leftBtn() {
         var leftArr = sliderObj.querySelector('.slider__arrowL');
         leftArr.addEventListener('click', function () {
            if (self.currentValue == 1) {
               self.currentValue = self.sliderLength;

               self.currentPos -= self.itemWidth * (self.sliderLength - 1);

               self.list.style.left = self.currentPos + 'px';

               return this;
            }

            self.currentPos += self.itemWidth;

            self.list.style.left = self.currentPos + 'px';
            self.currentValue--;
         });
      }

      function rightBtn() {
         var rightArr = sliderObj.querySelector('.slider__arrowR');
         rightArr.addEventListener('click', function () {
            if (self.currentValue == self.sliderLength) {
               self.currentValue = 1;

               self.currentPos += self.itemWidth * (self.sliderLength - 1);

               self.list.style.left = self.currentPos + 'px';

               return this;
            }

            self.currentPos -= self.itemWidth;

            self.list.style.left = self.currentPos + 'px';
            self.currentValue++;
         });
      }
   }

   /*          Images bar & Masonry        */

   (function () {
      var sections = ['Marshal', 'Wellnes and Health', 'Extreme  Sports and Expeditions', 'Fender', 'Culture and Edution', 'Les Paul', 'Relaxation', 'Travelling'];
      var inputText = sections[Math.floor(Math.random() * sections.length)]; // magic

      searching(inputText);
   })();

   function update(data) {
      if (!ResultsCheck(data)) {
         return false;
      }

      var grid = document.querySelector('.grid');
      var html = document.getElementById('grid').innerHTML;

      var links = data.hits.map(function (item) {
         return {
            link: item.webformatURL,
            word: item.user
         };
      });

      var compiled = tmpl(html, { data: links });
      grid.innerHTML = compiled;

      imagesLoaded(grid, function () {
         var msnry = new Masonry(grid, {
            itemSelector: '.grid__img',
            columnWidth: '.columnWidth',
            gutter: 20,
            percentPosition: true
         });
      });
      gridHover();
   }

   function gridHover() {
      var gridImages = document.querySelectorAll('.grid__mask');
      for (var _i3 = 0; _i3 < gridImages.length; _i3++) {
         gridImages[_i3].parentNode.addEventListener('mouseenter', function () {
            this.querySelector('.grid__mask').style.display = 'none';
            this.querySelector('.grid__info').style.display = 'none';
         });

         gridImages[_i3].parentNode.addEventListener('mouseleave', function () {
            this.querySelector('.grid__mask').style.display = 'inline-block';
            this.querySelector('.grid__info').style.display = 'inline-block';
         });

         gridImages[_i3].parentNode.addEventListener('click', function () {
            var imgSrc = this.getAttribute('data-src');
            var html = document.getElementById('mask').innerHTML;
            var page = document.getElementById('pagewrap');

            var maskWrapper = document.createElement('div');
            maskWrapper.classList.add('mask-wrapper');

            var compiled = tmpl(html, { data: imgSrc });
            maskWrapper.innerHTML = compiled;

            page.appendChild(maskWrapper);

            maskWrapper.addEventListener('click', function (e) {
               if (e.target.tagName == 'IMG') {
                  return false;
               } else {
                  page.removeChild(this);
               }
            });
         });
      }
   }

   function ResultsCheck(data) {

      function addNoResult(grid) {
         var noResults = document.createElement('p');
         noResults.classList.add('noResults');
         noResults.innerText = 'Sorry, no results found';

         grid.appendChild(noResults);

         return true;
      }

      function removeNoResult(grid) {
         if (grid.childNodes.length) {
            var item = grid.lastChild;
            do {
               grid.removeChild(item);
               item = grid.lastChild;
            } while (item);

            return true;
         } else {
            return false;
         }
      }

      function checking(data) {
         var grid = document.querySelector('.grid');
         if (!data.total) {

            if (grid.childNodes.length > 1) {
               removeNoResult(grid);
               addNoResult(grid);
               imagesLoaded(grid, function () {
                  var msnry = new Masonry(grid, {
                     itemSelector: '.grid__img',
                     columnWidth: '.columnWidth',
                     gutter: 20,
                     percentPosition: true
                  });
               });
            } else {
               if (grid.childNodes.length != 1) {
                  addNoResult(grid);
               }
            }

            return false;
         } else {
            removeNoResult(grid);

            return true;
         }
      }
      return checking(data);
   }

   function getXmlHttp() {
      var xmlhttp = void 0;
      try {
         xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
      } catch (e) {
         try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
         } catch (E) {
            xmlhttp = false;
         }
      }
      if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
         xmlhttp = new XMLHttpRequest();
      }
      return xmlhttp;
   }

   function searching(query) {
      var xmlhttp = getXmlHttp();
      var perPage = 7; // quantity of results

      xmlhttp.open('POST', 'https://pixabay.com/api/?key=4845683-933d895de826e8c128c7c84b3&per_page=' + perPage + '&q=' + query, true);
      xmlhttp.onreadystatechange = function () {
         if (xmlhttp.readyState == 4) {
            if (xmlhttp.status == 200) {
               update(JSON.parse(xmlhttp.responseText));
            } else {
               console.log('No access bla bla. Slow down please');
            }
         }
      };
      xmlhttp.send(null);
   }

   document.querySelector('.activity-search__btn').addEventListener('click', searchImgHandler);
   document.querySelector('.activity-search__input').addEventListener('keydown', function (e) {
      if (e.keyCode == 13) {
         e.preventDefault();
         searchImgHandler();
      }
   });

   function searchImgHandler() {
      var input = document.querySelector('.activity-search__input');

      if (input.value) {
         searching(input.value);
      }
   }
};