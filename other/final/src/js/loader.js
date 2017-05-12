'use strict';
// document.addEventListener("DOMContentLoaded", onReady);

function domReady(fn, context) {

    function onReady(event) {
        document.removeEventListener("DOMContentLoaded", onReady);
        fn.call(context, event);
    }

    function onReadyIe(event) {
        if (document.readyState === "complete") {
            document.detachEvent("onreadystatechange", onReadyIe);
            fn.call(context, event);
        }
    }

    document.addEventListener && document.addEventListener("DOMContentLoaded", onReady) ||
    document.attachEvent && document.attachEvent("onreadystatechange", onReadyIe);
}

function onPageReady() {
    loadSliders();
    loadMasonry();
}

domReady(onPageReady);
