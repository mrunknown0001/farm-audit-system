function printAreaDiv()
{
    var mywindow = window.open('', 'PRINT', 'height=900,width=800');

    mywindow.document.write('<html><head><title>' + 'Print' + '</title>');
    mywindow.document.write('<style>');
    mywindow.document.write('table {border-collapse: collapse;}');
    mywindow.document.write('table, tr, th, td {border: 1px solid black;}');
    mywindow.document.write('table {width: 100%;}');
    mywindow.document.write('table {text-align: center;}');
    mywindow.document.write('</style>');
    mywindow.document.write('</head><body >');
    mywindow.document.write(document.getElementById('student').innerHTML);
    mywindow.document.write(document.getElementById('printArea').innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;
}