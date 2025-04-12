var tableBesar = document.getElementById('tableBesar');
var inputValue = document.getElementById('searchValue');

inputValue.addEventListener('keyup', function(){
    var keyword = inputValue.value;
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if(xhr.readyState == 4 && xhr.status == 200){
            tableBesar.innerHTML = xhr.responseText;
        }
    }

    xhr.open('GET', './components/function/liveSearch.php?keyword=' + encodeURIComponent(keyword), true);
    xhr.send();    
});
