<?php
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<iframe src="" id="frame" width="100%" height="100%"></iframe>

<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://unpkg.com/jspdf-autotable@3.5.28/dist/jspdf.plugin.autotable.js"></script>

<script>
    window.jsPDF = window.jspdf.jsPDF;

    // Create new jsPdf instance
    const doc = new jsPDF()
    var pageNumber = 1;

    // Define header function
    const addHeader = function() {
        // Set font size and style for header
        doc.setFontSize(8)
        doc.setFont("Helvetica", "")

        doc.text('222-S0673-23', 10, 10)

        // Add date on right side
        const date = new Date().toLocaleDateString()
        doc.text(date, doc.internal.pageSize.width - 20, 10)
    }

    // Define footer function
    const addFooter = function() {
        // Set font size and style for header
        doc.setFontSize(8)
        doc.setFont("Helvetica", "")

        doc.text('Recway AB', 10, doc.internal.pageSize.height - 10)
        doc.setTextColor("#1A0DAB")
        doc.text('info@recway.nu', 10, doc.internal.pageSize.height - 7)

        doc.addImage("logo.png", "PNG", doc.internal.pageSize.width / 2 - 15, doc.internal.pageSize.height - 13, 30, 10)

        doc.setTextColor("#000000")
        doc.text(pageNumber.toString(), doc.internal.pageSize.width - 10, doc.internal.pageSize.height - 7)
    }

    // Add first page with header
    addHeader()

    var y = 20;
    doc.addImage("logo.png", 'PNG', 10, y, 30, 10)
    doc.setFont("Helvetica", 'Bold')
    // Set border properties
    var borderWidth = 0.5; // Width of the border
    var borderColor = "#AC0206"; // Color of the border

    doc.setTextColor("#AC0206")
    var textContent = " BESLUT: AVVIKELSE"; // Content of the text

    // Get the width and height of the text
    var textWidth = doc.getStringUnitWidth(textContent) * 3;
    var textHeight = doc.internal.getLineHeight() / doc.internal.scaleFactor;

    var textX = doc.internal.pageSize.width - 10 - textWidth; // X position of the text
    var textY = y; // Y position of the text

    // Draw the border
    doc.setLineWidth(borderWidth);
    doc.setDrawColor(borderColor);
    doc.rect(textX, textY - 1, textWidth, textHeight + 7);

    // Add the text inside the border
    doc.text(textX + borderWidth, textY + textHeight + 2, textContent);

    y = y + 30
    doc.setFontSize(20)
    doc.setTextColor("#000000")
    doc.text("Bakgrundskontroll Nivå 3", (doc.internal.pageSize.width / 2) - ((doc.getStringUnitWidth("Bakgrundskontroll Nivå 3") * 7) / 2) , y)

    y = y + 50
    doc.setFontSize(16)
    doc.text("Personalia", 15, y)

    var data = [
        {key: "Personnummer", value: "5002313335"},
        {key: "Förnamn", value: "David"},
        {key: "Mellannamn", value: "Edvard"},
        {key: "Folkbokföringsadress", value: "Holmens väg 6, 71001, BODEN, Norrbottens län, Luleå, Nederluleå"},
        {key: "In- och utvandring", value: "Personen förekommer inte med in- och utvandring."}
    ];

    y = y + 5
    doc.autoTable({
        startY: y,
        head: [{key: 'Key', value: 'Value'}],
        body: data,
        showHead: false,
        theme: 'grid',
        columnStyles: {
            key: { textColor: 0, fontStyle: 'bold' },
        },
        didParseCell: function(data) {
            if (data.row.index % 2 === 0) { // Check if odd row
                data.cell.styles.fillColor = [240, 240, 240] // Set background color to grey
            }
        }
    })

    addFooter()

    doc.addPage()
    pageNumber++;
    addHeader()
    addFooter()
    y = 30;

    doc.setFont("Helvetica", "Bold")
    doc.setFontSize(16)
    doc.text("Körkort", 15, y)

    data = [
        {key: "Körkortsbehörighet", value: "AM och B", result: "OK"},
        {key: "Återkallelse av körkort", value: "2021-09-18 återkallade Transportstyrelsen körkortet i tvåmånader pga en hastighetsöverträdelse", result: "OK"},
        {key: "Antal fordon ", value: "1", result: "OK"},
    ]

    y = y + 5
    doc.autoTable({
        startY: y,
        head: [{key: 'Key', value: 'Value', result: "Result"}],
        body: data,
        showHead: false,
        theme: 'grid',
        columnStyles: {
            key: { textColor: 0, fontStyle: 'bold' },
            result: {textColor: "#ffffff"}
        },
        didParseCell: function(data) {
            // Check if cell is in last column
            if (data.column.index === data.table.columns.length - 1) {
                // Set background color to green
                data.cell.styles.fillColor = [59, 116, 60];
            } else if (data.row.index % 2 === 0) {
                // Set background color to grey for even rows
                data.cell.styles.fillColor = [240, 240, 240];
            }
        }
    })

    y = doc.lastAutoTable.finalY + 15

    doc.setFont("Helvetica", "Bold")
    doc.setFontSize(16)
    doc.text("Ekonomi", 15, y)

    y = y + 5
    doc.autoTable({
        startY: y,
        head: [{key: 'Key', value: 'Value', result: "Result"}],
        body: data,
        showHead: false,
        theme: 'grid',
        columnStyles: {
            key: { textColor: 0, fontStyle: 'bold' },
            result: {textColor: "#ffffff"}
        },
        didParseCell: function(data) {
            // Check if cell is in last column
            if (data.column.index === data.table.columns.length - 1) {
                // Set background color to green
                data.cell.styles.fillColor = [59, 116, 60];
            } else if (data.row.index % 2 === 0) {
                // Set background color to grey for even rows
                data.cell.styles.fillColor = [240, 240, 240];
            }
        }
    })

    y = doc.lastAutoTable.finalY + 15

    doc.setFont("Helvetica", "Bold")
    doc.setFontSize(16)
    doc.text("Juridik", 15, y)

    y = y + 5
    doc.autoTable({
        startY: y,
        head: [{key: 'Key', value: 'Value', result: "Result"}],
        body: data,
        showHead: false,
        theme: 'grid',
        columnStyles: {
            key: { textColor: 0, fontStyle: 'bold' },
            result: {textColor: "#ffffff"}
        },
        didParseCell: function(data) {
            // Check if cell is in last column
            if (data.column.index === data.table.columns.length - 1) {
                // Set background color to green
                data.cell.styles.fillColor = [59, 116, 60];
            } else if (data.row.index % 2 === 0) {
                // Set background color to grey for even rows
                data.cell.styles.fillColor = [240, 240, 240];
            }
        }
    })

    y = doc.lastAutoTable.finalY + 15

    doc.setFont("Helvetica", "Bold")
    doc.setFontSize(16)
    doc.text("Bolagsengagemang", 15, y)

    y = y + 5
    doc.autoTable({
        startY: y,
        head: [{key: 'Key', value: 'Value', result: "Result"}],
        body: data,
        showHead: false,
        theme: 'grid',
        columnStyles: {
            key: { textColor: 0, fontStyle: 'bold' },
            result: {textColor: "#ffffff"}
        },
        didParseCell: function(data) {
            // Check if cell is in last column
            if (data.column.index === data.table.columns.length - 1) {
                // Set background color to green
                data.cell.styles.fillColor = [59, 116, 60];
            } else if (data.row.index % 2 === 0) {
                // Set background color to grey for even rows
                data.cell.styles.fillColor = [240, 240, 240];
            }
        }
    })

    y = doc.lastAutoTable.finalY + 15

    doc.setFont("Helvetica", "Bold")
    doc.setFontSize(16)
    doc.text("CV-kontroll arbetsgivare", 15, y)

    y = y + 5
    doc.autoTable({
        startY: y,
        head: [{key: 'Key', value: 'Value', result: "Result"}],
        body: data,
        showHead: false,
        theme: 'grid',
        columnStyles: {
            key: { textColor: 0, fontStyle: 'bold' },
            result: {textColor: "#ffffff"}
        },
        didParseCell: function(data) {
            // Check if cell is in last column
            if (data.column.index === data.table.columns.length - 1) {
                // Set background color to green
                data.cell.styles.fillColor = [59, 116, 60];
            } else if (data.row.index % 2 === 0) {
                // Set background color to grey for even rows
                data.cell.styles.fillColor = [240, 240, 240];
            }
        }
    })

    doc.addPage()
    pageNumber++;
    addHeader()
    addFooter()
    y = 30;

    doc.setFont("Helvetica", "Bold")
    doc.setFontSize(16)
    doc.text("Sociala medier", 15, y)

    y = y + 5
    doc.addImage("facebook.png", "PNG", 15, y, 10, 10)
    doc.link(15, y, 10, 10, {url: "https://www.facebook.com", target: '_blank'})

    doc.addImage("instagram.png", "PNG", 30, y, 10, 10)
    doc.link(30, y, 10, 10, {url: "https://www.instagram.com", target: '_blank'})

    doc.addImage("twitter.png", "PNG", 45, y, 10, 10)
    doc.link(45, y, 10, 10, {url: "https://www.twitter.com", target: '_blank'})

    y = y + 30
    doc.setFont("Helvetica", "Bold")
    doc.setFontSize(16)
    doc.text("Nyhetsdatabaser", 15, y)

    y = y + 10
    doc.setFont("Helvetica", "")
    doc.setFontSize(12)
    var text = "https://www.aftonbladet.se/nojesbladet/bolag-gick-46-miljoner-i-vinst 2019-05-19 publicerade Aftonbladet en artikel om David Dingel där hankommenterade en större vinst i sin koncern. I artikeln beskrivs att han driverflera olika bolag. Citat från artikel nedan:\"Men AB Syskrinet är det bolag han investerar mest i. Sedan 2011 harbolaget gått från 200 tusen i vinst till 46 miljoner 2018. En utdelning han ären aning obekväm att prata om.– Jag brukar verkligen aldrig prata om det här, men jag tror att det finnsnågon slags tabubelagd grej över det här i Sverige. Jag vet inte varför det ärså, dvs att få lov att tjäna pengar.";
    doc.text(text, 15, y, {maxWidth: doc.internal.pageSize.width - 30, align: "justify"})

    // Save document
    $('#frame').attr('src', doc.output("datauristring"))
</script>
</body>
</html>
