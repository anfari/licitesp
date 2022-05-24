const puppeteer = require('puppeteer');
const cron = require('node-cron');
const url = "https://contrataciondelestado.es/wps/portal/!ut/p/b1/04_SjzSzMDYyN7GwMNCP0I_KSyzLTE8syczPS8wB8aPM4k1c_Z2d3TyMDCyCjV0MjHxcQkPNPIBcd1Oggkh8CoyI029q7GwS5hUWYBbs6W5g4Onh5uITamgK1G5GnH4DHMDRgJD-cP0o_EqMoArwORGsAI8b_Dzyc1P1c6Ny3NwsPbNMHBUVAcPF9YU!/dl4/d5/L2dBISEvZ0FBIS9nQSEh/pw/Z7_AVEQAI930OBRD02JPMTPG21004/act/id=0/p=javax.servlet.include.path_info=QCPjspQCPbusquedaQCPMainBusqueda.jsp/511976870194/-/";


cron.schedule('*/15 * * * *', function() {
    getData();
});

getData();
async function getData() {
    var licitaciones = [];
    var request = require('request');

    try {
        let ultimaLicitacion = "";
        let breakLoop = false;
        request.get('http://licitesp/rest/Controlador/ControladorLicitacion.php?listar&pag=1&tamPag=1', {json: true}, (err, res, body) => {
            if (!err) {
                //console.log(body[0].expediente);
                if (body[0]) {
                    ultimaLicitacion = body[0].expediente;
                }
            }
        })

        const browser = await puppeteer.launch({ headless: true });
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
        while(await page.$('#viewns_Z7_AVEQAI930OBRD02JPMTPG21004_\\:form1\\:footerSiguiente') && x < 3 && !breakLoop) {
            x++;
        for (let i = 0; i < 20; i++) {
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
            //organo_contratacion = organo_contratacion.replace("/'/g", "\\'");
            organo_contratacion = organo_contratacion.split("'").join("\\'");
            element = await page2.$('#viewns_Z7_AVEQAI930OBRD02JPMTPG21006_\\:form1\\:text_Expediente');
            let expediente = await page2.evaluate(element => element.textContent, element);

            if (expediente == ultimaLicitacion) {
                break;
            }

            element = await page2.$('#viewns_Z7_AVEQAI930OBRD02JPMTPG21006_\\:form1\\:text_ObjetoContrato');
            let objeto_contrato = await page2.evaluate(element => element.textContent, element);
            //objeto_contrato = objeto_contrato.replace("/'/g", "\\'");
            objeto_contrato = objeto_contrato.split("'").join("\\'");
            element = await page2.$('#viewns_Z7_AVEQAI930OBRD02JPMTPG21006_\\:form1\\:text_ValorContrato');
            let valor_estimado = await page2.evaluate(element => element.textContent, element);
            element = await page2.$('#viewns_Z7_AVEQAI930OBRD02JPMTPG21006_\\:form1\\:text_TipoContrato');
            let tipo = await page2.evaluate(element => element.textContent, element);
            element = await page2.$('#viewns_Z7_AVEQAI930OBRD02JPMTPG21006_\\:form1\\:text_LugarEjecucion');
            let le = await page2.evaluate(element => element.textContent, element);
            let lugar_ejecucion = le.substring(9);
            element = await page2.$('#viewns_Z7_AVEQAI930OBRD02JPMTPG21006_\\:form1\\:text_FechaPresentacionOfertaConHora');
            let plazo = "";
            if (element != null) {
                plazo = await page2.evaluate(element => element.textContent, element);
            }
            if (element == null) {
                element = await page2.$('#viewns_Z7_AVEQAI930OBRD02JPMTPG21006_\\:form1\\:text_FechaLimiteSolicitudParticipacionConHora');
                plazo = await page2.evaluate(element => element.textContent, element);
            }
            let enlace = page2.url().replace(":", "\:");


            const licitacion = {
                "expediente":expediente,
                "organo_contratacion":organo_contratacion,
                "objeto_contrato":objeto_contrato,
                "valor_estimado":valor_estimado,
                "tipo":tipo,
                "lugar_ejecucion":lugar_ejecucion,
                "plazo":plazo,
                "enlace":enlace
            }

            licitaciones.push(licitacion);

        }
        await page.click('#viewns_Z7_AVEQAI930OBRD02JPMTPG21004_\\:form1\\:footerSiguiente');
        await page.waitForSelector('#myTablaBusquedaCustom');
        }

        

        console.log(licitaciones.length);
        console.log(licitaciones);

        await page.close();
        await browser.close();

        
        request.post(
            'http://licitesp/rest/Controlador/ControladorLicitacion.php',
            { json: {data: JSON.stringify(licitaciones)} },
            function (error, response, body) {
                if (!error && response.statusCode == 200) {
                    console.log(body);
                }
            }
        );
        console.log(licitaciones.length);

    } catch (e) {
        console.log(e);
        console.log(licitaciones);
        console.log(licitaciones.length);

        request.post(
            'http://licitesp/rest/Controlador/ControladorLicitacion.php',
            { json: {data: JSON.stringify(licitaciones)} },
            function (error, response, body) {
                if (!error && response.statusCode == 200) {
                    console.log(body);
                }
            }
        );
    }
};
