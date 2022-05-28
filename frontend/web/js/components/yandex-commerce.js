/**
 * Используется для отправки данных о достижении целей в Яндекс.Коммерцию
 */

class YandexCommerce {

    viewProduct({id, name, price, category}) {
        this.push({
            'ecommerce': {
                'detail': {
                    'products': [{id, name, price, category}]
                }
            }
        });
    }

    addToCartProduct({id, name, price, quantity, category}) {
        this.push({
            'ecommerce': {
                "currencyCode": "RUB",
                'add': {
                    'products': [{id, name, price, quantity, category}]
                }
            }
        });
    }

    purchase({orderId, revenue, productId, name, price, category}) {
        this.push({
            'ecommerce': {
                'currencyCode': "RUB",
                'purchase': {
                    'actionField': {'id': orderId, revenue},
                    'products': [{id: productId, name, price, category}],
                }
            }
        });
    }

    push(data) {
        if (window.dataLayer) {
            console.log("Yandexe.Commerce Pushed")
            window.dataLayer.push(data);
        } else {
            console.warn('Yandex.Commerce "dataLayer" not initialized or has another name. ')
        }
    }
}