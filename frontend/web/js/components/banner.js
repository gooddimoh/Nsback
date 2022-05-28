/**
 * Прототип рекламного блока среди списка товаров для Партнерского размещения.
 */

showBanner();

// #############################
function showBannerInAssociatedWithFacebook() {
    const targetUrls = ["group/view/facebook", "category/view/facebook"];
    const targetCategory = 31;
    let url = window.location.href;
    let isTargetPage = targetUrls.filter((targetUrl) => {
        return url.indexOf(targetUrl) !== -1;
    });
    let resultBlocks = [];

    if (document.getElementById("main-page") || isTargetPage.length > 0) {
        for (let productBlock of document.getElementsByClassName("accounts__items")) {
            if (productBlock.dataset.category && productBlock.dataset.category == targetCategory) {
                resultBlocks.push(productBlock);
            }
        }
    }

    return showBannerIn(resultBlocks);
}

function showBanner() {
    let blocks = document.getElementsByClassName("accounts__items");

    let even = 2;
    let blocksFilters = [];
    for (let i = 0; i < blocks.length; i++) {
        if (even == 2) {
            even = 0;
            blocksFilters.push(blocks[i]);
        }
        even++;
    }

    showBannerIn(blocksFilters);
}

function showBannerIn(blocks) {
    console.log(blocks)
    const productBlockInjector = function (block) {
        if (block.children.item(0)) {
            block.children.item(0).before(createBanner());
        }
    };

    for (let block of blocks) {
        productBlockInjector(block);
    }
}

function createBanner() {
    //let src = "https://imgru.com/a9cb279917ae36.jpg";
    let text = "Лучшие Мобильные, Резидентные, Серверные прокси RU, UA, EU, USA! Более 5 лет на рынке прокси. RU прокси с обходом для работы в заблокированных соц-сетях! Быстрая тех-поддержка. Компенсация простоя!";
    let url = "https://lteboost.com/";

    const banner = document.createElement("div");
    banner.classList.add("account__item");
    banner.innerHTML = `
    <div class="account__item-main">
        <div class="account__item-image">
            <a class="account__item-image-src" target="_blank" href="#">
                <!---
                <img alt="Рекламная вставка" src="#" width="20">
                -->
            </a>
        </div>
        <div class="account__item-title">
            <a href="${url}" target="_blank">
                <span>${text}</span>
            </a>
        </div>
    </div>
    <div class="account__item-middle">
        <div class="goods__controls">
             <a class="button goods__controls-btn" target="_blank" href="${url}" role="button">Попробовать</a>
         </div>
    </div>`;

    return banner;
}