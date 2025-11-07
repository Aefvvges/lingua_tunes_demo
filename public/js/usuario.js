window.onload = function() {
    var input1 = document.getElementById('bloquear-1');
    input1.onpaste = function(e) {
        e.preventDefault();
    }
    var input2 = document.getElementById('bloquear-2');
    input2.onpaste = function(e) {
        e.preventDefault();
    }
}