/**
 * Используется для переключения табов с информацией на странице товаров
 */

{
    const TAB_CLASS = "tab";
    const TAB_ACTIVE_CLASS = "active";
    const TAB_CONTENT_CLASS = "tab-content";

    const handleClick = e => {
        e.preventDefault();
        let targetTab = e.target;

        doActionForTabs((tab) => {
            tab.classList.remove(TAB_ACTIVE_CLASS);

            let content = document.getElementById(tab.dataset.target);
            if (content) {
                content.style.display = tab.dataset.target === targetTab.dataset.target ? "block" : "none";
            }
        });

        targetTab.classList.add(TAB_ACTIVE_CLASS);
    };

    const doActionForTabs = (action) => {
        for (let tab of document.getElementsByClassName(TAB_CLASS)) {
            action(tab);
        }
    };

    const init = () => {
        for (let content of document.getElementsByClassName(TAB_CONTENT_CLASS)) {
            content.style.display = "none";
        }
        doActionForTabs(tab => tab.addEventListener("click", handleClick));
        doActionForTabs(tab => {
            if (tab.classList.contains(TAB_ACTIVE_CLASS)) {
                tab.dispatchEvent(new Event("click"))
            }
        })
    };

// Init
    init();
}