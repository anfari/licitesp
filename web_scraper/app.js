const puppeteer = require('puppeteer');
const url = "https://contrataciondelestado.es/wps/portal/!ut/p/b1/04_SjzSzMDYyN7GwMNCP0I_KSyzLTE8syczPS8wB8aPM4k1c_Z2d3TyMDCyCjV0MjHxcQkPNPIBcd1Oggkh8CoyI029q7GwS5hUWYBbs6W5g4Onh5uITamgK1G5GnH4DHMDRgJD-cP0o_EqMoArwORGsAI8b_Dzyc1P1c6Ny3NwsPbNMHBUVAcPF9YU!/dl4/d5/L2dBISEvZ0FBIS9nQSEh/pw/Z7_AVEQAI930OBRD02JPMTPG21004/act/id=0/p=javax.servlet.include.path_info=QCPjspQCPbusquedaQCPMainBusqueda.jsp/511976870194/-/";

( async () => {

    try {
        const browser = await puppeteer.launch({ headless: false });
        const page = await browser.newPage();

        await page.goto(url);
        await page.screenshot({
            path: "./test1.png",
            fullPage: true
        });

        await page.click('.divLogo a');
        await page.waitForSelector('#viewns_Z7_AVEQAI930OBRD02JPMTPG21004_\\:form1\\:estadoLici')
        await page.select('select#viewns_Z7_AVEQAI930OBRD02JPMTPG21004_\\:form1\\:estadoLici', 'PUB');
        //await page.select('select#viewns_Z7_AVEQAI930OBRD02JPMTPG21004_\\:form1\\:menu1MAQ1', 'ES');

        //await page.waitForNavigation(),
        await page.click('#viewns_Z7_AVEQAI930OBRD02JPMTPG21004_\\:form1\\:button1');
        await page.waitForSelector('#myTablaBusquedaCustom');
        await page.waitForTimeout(2000);


        await page.screenshot({
            path: "./test2.png",
            fullPage: true
        });

        
        const licitaciones = [];

        const page2 = await browser.newPage();
        let x = 0;
        while(await page.$('#viewns_Z7_AVEQAI930OBRD02JPMTPG21004_\\:form1\\:footerSiguiente') || x != 2) {
        x++;
        for (let i = 0; i < 3; i++) {
            await page2.goto(page.url());
            await page2.waitForSelector('#myTablaBusquedaCustom');
            await page2.waitForTimeout(1000);
            await page2.click('#viewns_Z7_AVEQAI930OBRD02JPMTPG21004_\\:form1\\:enlaceExpediente_' + i);
            await page2.waitForTimeout(1000);
            await page2.waitForSelector('#DetalleLicitacionVIS_UOE');

            let element = await page2.$('#viewns_Z7_AVEQAI930OBRD02JPMTPG21006_\\:form1\\:text_OC_con');
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
            let plazo_ejecucion = await page2.evaluate(element => element.textContent, element);


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
    } catch (e) {
        console.log(e);
    }
})();
