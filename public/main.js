function updateDateFields(event){
    const selectedValue = event.target.value
    document.getElementById("date-after").value = selectedValue + "-01-01";
    document.getElementById("date-before").value = selectedValue + "-12-31";
}