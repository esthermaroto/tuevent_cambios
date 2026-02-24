const puppeteer = require('puppeteer');

(async () => {
  const browser = await puppeteer.launch();
  const page = await browser.newPage();
  await page.setViewport({ width: 1920, height: 1080 });
  
  await page.goto('http://localhost:8000/index.html', {waitUntil: 'networkidle2'});
  await page.screenshot({path: 'index_test2.png', fullPage: true});
  
  await page.goto('http://localhost:8000/eventos.html', {waitUntil: 'networkidle2'});
  await page.screenshot({path: 'eventos_test2.png', fullPage: true});

  await page.goto('http://localhost:8000/produccion.html', {waitUntil: 'networkidle2'});
  await page.screenshot({path: 'produccion_test2.png', fullPage: true});
  
  await page.goto('http://localhost:8000/portfolio.html', {waitUntil: 'networkidle2'});
  await page.screenshot({path: 'portfolio_test2.png', fullPage: true});

  await browser.close();
})();
