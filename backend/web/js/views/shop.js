{
    const controlInternalMarkup = (shopField, internalBlock, internalActivator, disableFocus = false) => {
        let internalField = internalBlock.find("input");

        if (shopField.val() == 0) {
            internalActivator.hide();
            internalBlock.show();
            disableFocus || internalField.focus();
        } else {
            internalActivator.show();
            internalField.val('');
            internalBlock.hide();
        }
    }

    let shopMarkupField = $("#shop-markup");
    let internalMarkupBlock = $("#internal-markup-block");
    let internalMarkupActivator = $("#internal-markup-activator");
    const activateControl = (disableFocus = false) => {
        controlInternalMarkup(shopMarkupField, internalMarkupBlock, internalMarkupActivator, disableFocus);
    }
    
    // Initial
    activateControl(true);
    // Events
    $(shopMarkupField).on("input", () => activateControl());
    $(internalMarkupActivator).on("click", () => {
        shopMarkupField.val(0);
        activateControl();
    });

}