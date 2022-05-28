/**
 * Используется в навигации для быстрого перемещения по категориям на главной странице
 */
{
    const categorySelect = document.getElementById("select-category");
    const inner = document.getElementById("selectfly-inner");

    const findCategoryBlock = categoryId => {
        return document.querySelector(`.accounts__items[data-category="${categoryId}"]`);
    };
    const handleClick = e => {
        let block = findCategoryBlock(e.target.dataset.category);

        if (block) {
            block.scrollIntoView();
        }
    };
    const itemCreator = (categoryId, name, icon, callback = null) => {
        let item = document.createElement("div");
        item.className = 'selectfly__item';
        item.dataset.floatfly = "option";
        item.innerHTML = `<div class="selectfly__option"><img data-category="${categoryId}" title="${name}" alt="${name}" src="${icon}"></div>`;
        item.querySelector("img").addEventListener("click", callback || handleClick);

        return item;
    }

    if (inner) {
        inner.innerText = "";

        for (let option of categorySelect.options) {
            if (option.value !== '' && findCategoryBlock(option.value)) {
                inner.append(itemCreator(option.value, option.innerText, option.dataset.icon));
            }
        }

        inner.append(itemCreator(null, 'Показать все категории', 'img/show-more.png', () => {
            window.location.href = '/categories';
        }))
    }


}