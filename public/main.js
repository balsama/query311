function updateAddressLabel(event){
    if (event.currentTarget.checked) {
        document.getElementById("address-contains-label").innerText = "Address (contains)";
    }
    else {
        document.getElementById("address-contains-label").innerText = "Address (starts with)";
    }
}
function updateDateFields(event){
    const selectedValue = event.target.value;
    document.getElementById("date-after").value = selectedValue + "-01-01";
    document.getElementById("date-before").value = selectedValue + "-12-31";
}