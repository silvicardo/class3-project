(function() {

    function moveElementsFromTo(source, destination) {
        var bigNumber = 1000;
        while (source.firstElementChild) {
            if (source.firstElementChild !== destination) {
                destination.appendChild(source.firstElementChild);
            }
            if (source.firstElementChild === destination && source.childElementCount === 1 || bigNumber-- === 0) {
                break;
            }
        }
    }

    function resetForms() {
        var form;
        if (document.forms.length) {
            var i;
            for (i in document.forms) {
                form = document.forms[i];
                if (form instanceof HTMLElement) {
                    form.reset();
                }
            }
        }
    }

    function wrapBody() {
        var form = document.createElement('form');
        document.body.appendChild(form);
        moveElementsFromTo(document.body, form);
        form.reset();
    }

    function unwrapBody() {
        var form = document.querySelector('form');
        if (form && document.body.firstElementChild === form) {
            moveElementsFromTo(form, document.body);
        }
    }

    function clearForms() {
        var elems = document.querySelector('select,input,textarea,datalist');
        if (elems || elems.length === 0) {
            return;
        }
        resetForms();
        wrapBody();
        unwrapBody();
    }

    window.addEventListener('beforeunload', clearForms);

})();
