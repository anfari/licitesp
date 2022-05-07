const puppeteer = require('puppeteer');
const url = "https://contrataciondelestado.es/wps/portal/!ut/p/b1/04_SjzSzMDYyN7GwMNCP0I_KSyzLTE8syczPS8wB8aPM4k1c_Z2d3TyMDCyCjV0MjHxcQkPNPIBcd1Oggkh8CoyI029q7GwS5hUWYBbs6W5g4Onh5uITamgK1G5GnH4DHMDRgJD-cP0o_EqMoArwORGsAI8b_Dzyc1P1c6Ny3NwsPbNMHBUVAcPF9YU!/dl4/d5/L2dBISEvZ0FBIS9nQSEh/pw/Z7_AVEQAI930OBRD02JPMTPG21004/act/id=0/p=javax.servlet.include.path_info=QCPjspQCPbusquedaQCPMainBusqueda.jsp/511976870194/-/";

//var url = "http://licitesp/rest/Controlador/ControladorLicitacion.php";
var data = '{"operacion": "listar"}';

/*var request = require('request');
request.post(
    'http://licitesp/rest/Controlador/ControladorLicitacion.php',
    { json: { 'operacion': 'listar' } },
    function (error, response, body) {
        if (!error && response.statusCode == 200) {
            console.log(body);
        }
    }
);*/

var data = {
    operacion:"listar"
 };
 var querystring = require("querystring");
 var qs = querystring.stringify(data);
 var qslength = qs.length;
 var options = {
     hostname: "licitesp",
     port: 80,
     path: "rest/Controlador/ControladorLicitacion.php",
     method: 'POST',
     headers:{
         'Content-Type': 'application/x-www-form-urlencoded',
         'Content-Length': qslength
     }
 };
 
 var buffer = "";
 var req = http.request(options, function(res) {
     res.on('data', function (chunk) {
        buffer+=chunk;
     });
     res.on('end', function() {
         console.log(buffer);
     });
 });
 
 req.write(qs);
 req.end();


( async () => {
    const licitaciones = [];

    /*try {
        const browser = await puppeteer.launch({ headless: false });
        const page = await browser.newPage();

        await page.goto(url);

        await page.click('.divLogo a');
        await page.waitForSelector('#viewns_Z7_AVEQAI930OBRD02JPMTPG21004_\\:form1\\:estadoLici')
        await page.select('select#viewns_Z7_AVEQAI930OBRD02JPMTPG21004_\\:form1\\:estadoLici', 'PUB');

        await page.click('#viewns_Z7_AVEQAI930OBRD02JPMTPG21004_\\:form1\\:button1');
        await page.waitForSelector('#myTablaBusquedaCustom');
        await page.waitForTimeout(2000);


        const page2 = await browser.newPage();
        let x = 0;
        while(await page.$('#viewns_Z7_AVEQAI930OBRD02JPMTPG21004_\\:form1\\:footerSiguiente') && x <= 0) {
            x++;
        for (let i = 0; i < 0; i++) {
            await page2.goto(page.url());
            await page2.waitForSelector('#myTablaBusquedaCustom');
            await page2.waitForTimeout(1000);
            await page2.click('#viewns_Z7_AVEQAI930OBRD02JPMTPG21004_\\:form1\\:enlaceExpediente_' + i);
            await page2.waitForTimeout(1000);
            await page2.waitForSelector('#DetalleLicitacionVIS_UOE');

            let element = await page2.$('#viewns_Z7_AVEQAI930OBRD02JPMTPG21006_\\:form1\\:text_OC_con');
            if (element == null) {
                element = await page2.$('#viewns_Z7_AVEQAI930OBRD02JPMTPG21006_\\:form1\\:text_OC_sin');
            }
            let organo_contratacion = await page2.evaluate(element => element.textContent, element);
            element = await page2.$('#viewns_Z7_AVEQAI930OBRD02JPMTPG21006_\\:form1\\:text_ObjetoContrato');
            let objeto_contrato = await page2.evaluate(element => element.textContent, element);
            element = await page2.$('#viewns_Z7_AVEQAI930OBRD02JPMTPG21006_\\:form1\\:text_ValorContrato');
            let valor_estimado = await page2.evaluate(element => element.textContent, element);
            element = await page2.$('#viewns_Z7_AVEQAI930OBRD02JPMTPG21006_\\:form1\\:text_TipoContrato');
            let tipo = await page2.evaluate(element => element.textContent, element);
            element = await page2.$('#viewns_Z7_AVEQAI930OBRD02JPMTPG21006_\\:form1\\:text_LugarEjecucion');
            let lugar_ejecucion = await page2.evaluate(element => element.textContent, element);
            element = await page2.$('#viewns_Z7_AVEQAI930OBRD02JPMTPG21006_\\:form1\\:text_FechaPresentacionOfertaConHora');
            let plazo_ejecucion = "";
            if (element != null) {
                plazo_ejecucion = await page2.evaluate(element => element.textContent, element);
            }
            if (element == null) {
                element = await page2.$('#viewns_Z7_AVEQAI930OBRD02JPMTPG21006_\\:form1\\:text_FechaLimiteSolicitudParticipacionConHora');
                plazo_ejecucion = await page2.evaluate(element => element.textContent, element);
            }
            


            const licitacion = {
                "organo_contratacion":organo_contratacion,
                "objeto_contrato":objeto_contrato,
                "valor_estimado":valor_estimado,
                "tipo":tipo,
                "lugar_ejecucion":lugar_ejecucion,
                "plazo_ejecucion":plazo_ejecucion,
                "url":page2.url()
            }

            licitaciones.push(licitacion);

        }
        await page.click('#viewns_Z7_AVEQAI930OBRD02JPMTPG21004_\\:form1\\:footerSiguiente');
        await page.waitForSelector('#myTablaBusquedaCustom');
        }

        

        console.log(licitaciones.length);

        await page.close();
        await browser.close();

        /*const userAction = async () => {
            const response = await fetch('http://licitesp/movies.json', {
              method: 'POST',
              body: myBody, // string or object
              headers: {
                'Content-Type': 'application/json'
              }
            });
            const myJson = await response.json(); //extract JSON from the http response
            // do something with myJson
        }*/
/*
    } catch (e) {
        console.log(e);
        console.log(licitaciones);
        console.log(licitaciones.length);
    }*/
})();
