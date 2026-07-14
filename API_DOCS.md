# Stokku API Documentation

Base Url: 'http://localhost:8000/api'

Authetication: Bearer Token (Sanctum)

***

\##Auth

### POST /login

Login dan dapat token.

**Body**
Field | Type   | Required
email | string | true

**Response 200**

```json
{
    "token": "15|0FXj6zKhDs1AqZmgUP4EBd521NA7T6y24KpThVfz1b93ae5d",
    "user": { "id": 1, "name": "Admin", "email": "admin@gmail.com", "role": "admin" }
}

### POST /logout
Revoke token, Auth required

Response 200:
{ "message": "Logged out" }

### GET /me
User login

Response 200:
{
    "me": {
        "id": 1,
        "name": "Admin",
        "email": "admin@gmail.com",
        "role": "admin",
        "email_verified_at": null,
        "created_at": "2026-07-11T06:50:00.000000Z",
        "updated_at": "2026-07-11T06:50:00.000000Z"
    }
}

##Category
###POST /categories
Field | Type | Required
name  | string | true
slug  | string | true

Response 200
{
    "success": true,
    "data": {
        "name": "Seafood",
        "slug": "seafood",
        "updated_at": "2026-07-14T14:20:10.000000Z",
        "created_at": "2026-07-14T14:20:10.000000Z",
        "id": 8
    }
}

###GET /categories

Response 200
{
    "success": true,
    "data": [
        {
            "id": 3,
            "name": "Minuman",
            "slug": "minuman",
            "created_at": "2026-07-11T08:22:42.000000Z",
            "updated_at": "2026-07-11T08:24:20.000000Z",
            "deleted_at": null
        }
    ]
}

###GET /categories/{category}

Response 200
{
    "success": true,
    "data": {
        "id": 4,
        "name": "Makanan",
        "slug": "makanan",
        "created_at": "2026-07-13T02:20:29.000000Z",
        "updated_at": "2026-07-13T02:20:29.000000Z",
        "deleted_at": null
    }
}

###PUT /categories/{category}

Response 200
{
    "success": true,
    "data": {
        "id": 4,
        "name": "Pocha",
        "slug": "pocha",
        "created_at": "2026-07-13T02:20:29.000000Z",
        "updated_at": "2026-07-14T14:24:47.000000Z",
        "deleted_at": null
    }
}

###DELETE /categories/{category}

Response 200
{
    "success": true,
    "data": {
        "id": 4,
        "name": "Pocha",
        "slug": "pocha",
        "created_at": "2026-07-13T02:20:29.000000Z",
        "updated_at": "2026-07-14T14:25:28.000000Z",
        "deleted_at": "2026-07-14T14:25:28.000000Z"
    }
}

##Product

###POST /products

Field | Type | Required
category_id | int | true
supplier_id | int | true
name | string | true
sku | string | true
price | numerci:decimal | true
stock | integer | true
min_stock | integer | true
image | image | true

Response 200
{
    "success": true,
    "data": {
        "category_id": "4",
        "supplier_id": "2",
        "name": "Jasuke",
        "sku": "JSK",
        "price": "10000.00",
        "stock": "8",
        "min_stock": "1",
        "image_path": "products/nV5GIz3Q3C2cFJIHtSpxKAJxfW0JSJdR8mmcrL90.jpg",
        "is_active": false,
        "updated_at": "2026-07-14T14:28:36.000000Z",
        "created_at": "2026-07-14T14:28:36.000000Z",
        "id": 24
    }
}

###GET /products?category_id=?is_active=

Response 200
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 2,
                "category_id": 4,
                "supplier_id": 2,
                "name": "Pizza",
                "sku": "PZZ",
                "price": "28000.00",
                "stock": 0,
                "min_stock": 1,
                "image_path": "images/BNkNAweZh0V1dGyBhpIt0LX2z7GDnRd91hvzJNNj.jpg",
                "is_active": 0,
                "created_at": "2026-07-13T02:26:27.000000Z",
                "updated_at": "2026-07-13T16:27:58.000000Z",
                "deleted_at": null,
                "category": null,
                "supplier": {
                    "id": 2,
                    "name": "Nafis",
                    "email": "nafis@gmail.com",
                    "phone": "0895391622424",
                    "address": "Ngadirno Klero, rt15 rw 04",
                    "created_at": "2026-07-11T08:49:34.000000Z",
                    "updated_at": "2026-07-11T08:49:34.000000Z",
                    "deleted_at": null
                }
            }
        ],
        "first_page_url": "http://localhost:8000/api/products?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://localhost:8000/api/products?page=1",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "page": null,
                "active": false
            },
            {
                "url": "http://localhost:8000/api/products?page=1",
                "label": "1",
                "page": 1,
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "page": null,
                "active": false
            }
        ],
        "next_page_url": null,
        "path": "http://localhost:8000/api/products",
        "per_page": 10,
        "prev_page_url": null,
        "to": 5,
        "total": 5
    }
}

###GET /products/{product}

Response 200
{
    "success": true,
    "data": {
        "id": 3,
        "category_id": 4,
        "supplier_id": 2,
        "name": "Buggle",
        "sku": "BGL",
        "price": "18000.00",
        "stock": 0,
        "min_stock": 1,
        "image_path": "products/GBaLL37YBSA5mb7ku8mp6LA4rIzjddIbRg5lc3tR.jpg",
        "is_active": 0,
        "created_at": "2026-07-13T02:32:36.000000Z",
        "updated_at": "2026-07-13T16:29:44.000000Z",
        "deleted_at": null
    },
    "stock": 0
}

###POST /products/{product}

Field | Type | Required
category_id | int | true
supplier_id | int | true
name | string | true
sku | string | true
price | numerci:decimal | true
stock | integer | true
min_stock | integer | true
image | image | true

Response 200
{
    "success": true,
    "data": {
        "id": 14,
        "category_id": 5,
        "supplier_id": 4,
        "name": "Noodle",
        "sku": "NDL",
        "price": "15000.00",
        "stock": 20,
        "min_stock": 2,
        "image_path": "products/Lq0W3oyf05wyfogsVZOox9k8JakCE1o35xJpE4ej.jpg",
        "is_active": 0,
        "created_at": "2026-07-13T13:18:46.000000Z",
        "updated_at": "2026-07-14T14:31:08.000000Z",
        "deleted_at": null
    }
}

###DELETE /products/{product}

Response 200
{
    "success": true,
    "data": {
        "id": 14,
        "category_id": 5,
        "supplier_id": 4,
        "name": "Noodle",
        "sku": "NDL",
        "price": "15000.00",
        "stock": 20,
        "min_stock": 2,
        "image_path": "products/Lq0W3oyf05wyfogsVZOox9k8JakCE1o35xJpE4ej.jpg",
        "is_active": 0,
        "created_at": "2026-07-13T13:18:46.000000Z",
        "updated_at": "2026-07-14T14:31:35.000000Z",
        "deleted_at": "2026-07-14T14:31:35.000000Z"
    }
}

##Supplier 

###POST /suppliers

Field | type | required
name | string | true
email | email | true
phone | integer | true
address | string | true

Response 200
{
    "success": true,
    "data": {
        "name": "Izzzaqi",
        "email": "zaqia@gmail.com",
        "phone": "083345671234",
        "address": "Sidodadi, Kembang, Ampel",
        "updated_at": "2026-07-14T14:33:11.000000Z",
        "created_at": "2026-07-14T14:33:11.000000Z",
        "id": 7
    }
}

###GET /suppliers

Response 200
{
    "success": true,
    "data": [
        {
            "id": 2,
            "name": "Nafis",
            "email": "nafis@gmail.com",
            "phone": "0895391622424",
            "address": "Ngadirno Klero, rt15 rw 04",
            "created_at": "2026-07-11T08:49:34.000000Z",
            "updated_at": "2026-07-11T08:49:34.000000Z",
            "deleted_at": null
        }
    ]
}

###GET /suppliers/{supplier}

Response 200
{
    "success": true,
    "data": {
        "id": 4,
        "name": "Test1",
        "email": "test1@gmail.com",
        "phone": "0099988877765",
        "address": "Jakarta",
        "created_at": "2026-07-13T12:58:22.000000Z",
        "updated_at": "2026-07-13T12:58:22.000000Z",
        "deleted_at": null
    }
}

###PUT /suppliers/{supplier}

Field | type | required
name | string | true
email | email | true
phone | integer | true
address | string | true

Response 200
{
    "success": true,
    "data": {
        "id": 4,
        "name": "Izzaqi",
        "email": "izzaqis@gmail.com",
        "phone": "1234567897",
        "address": "Semarang Banyumanik Blok O2",
        "created_at": "2026-07-13T12:58:22.000000Z",
        "updated_at": "2026-07-14T14:34:59.000000Z",
        "deleted_at": null
    }
}

###DELETE /suppliers/{supplier}

Response 200
{
    "success": true,
    "data": {
        "id": 4,
        "name": "Izzaqi",
        "email": "izzaqis@gmail.com",
        "phone": "1234567897",
        "address": "Semarang Banyumanik Blok O2",
        "created_at": "2026-07-13T12:58:22.000000Z",
        "updated_at": "2026-07-14T14:35:23.000000Z",
        "deleted_at": "2026-07-14T14:35:23.000000Z"
    }
}

##Stock transaction

###POST /transactions

Field | type | required
product_id | int | true
user_id | int | true
type | bool(in|out) | true
quantity | integer | true
note | text | nullable

Response 200
{
    "success": true,
    "data": {
        "product_id": "18",
        "user_id": 1,
        "type": "out",
        "quantity": "2",
        "stock_before": 59,
        "stock_after": 57,
        "note": "Test",
        "updated_at": "2026-07-14T14:37:22.000000Z",
        "created_at": "2026-07-14T14:37:22.000000Z",
        "id": 4,
        "product": {
            "id": 18,
            "category_id": 5,
            "supplier_id": 6,
            "name": "Cheese Rice Bowl",
            "sku": "P-T5A",
            "price": "28879.00",
            "stock": 57,
            "min_stock": 1,
            "image_path": "https://via.placeholder.com/640x480.png/00cc33?text=products+placeat",
            "is_active": 0,
            "created_at": "2026-07-13T13:18:46.000000Z",
            "updated_at": "2026-07-14T14:37:22.000000Z",
            "deleted_at": null
        },
        "user": {
            "id": 1,
            "name": "Admin",
            "email": "admin@gmail.com",
            "role": "admin",
            "email_verified_at": null,
            "created_at": "2026-07-11T06:50:00.000000Z",
            "updated_at": "2026-07-11T06:50:00.000000Z"
        }
    }
}

###GET /transactions?product_id

Response 200
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 4,
                "product_id": 18,
                "user_id": 1,
                "type": "out",
                "quantity": 2,
                "stock_before": 59,
                "stock_after": 57,
                "note": "Test",
                "created_at": "2026-07-14T14:37:22.000000Z",
                "updated_at": "2026-07-14T14:37:22.000000Z",
                "product": {
                    "id": 18,
                    "category_id": 5,
                    "supplier_id": 6,
                    "name": "Cheese Rice Bowl",
                    "sku": "P-T5A",
                    "price": "28879.00",
                    "stock": 57,
                    "min_stock": 1,
                    "image_path": "https://via.placeholder.com/640x480.png/00cc33?text=products+placeat",
                    "is_active": 0,
                    "created_at": "2026-07-13T13:18:46.000000Z",
                    "updated_at": "2026-07-14T14:37:22.000000Z",
                    "deleted_at": null
                },
                "user": {
                    "id": 1,
                    "name": "Admin",
                    "email": "admin@gmail.com",
                    "role": "admin",
                    "email_verified_at": null,
                    "created_at": "2026-07-11T06:50:00.000000Z",
                    "updated_at": "2026-07-11T06:50:00.000000Z"
                }
            }
        ],
        "first_page_url": "http://localhost:8000/api/transactions?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://localhost:8000/api/transactions?page=1",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "page": null,
                "active": false
            },
            {
                "url": "http://localhost:8000/api/transactions?page=1",
                "label": "1",
                "page": 1,
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "page": null,
                "active": false
            }
        ],
        "next_page_url": null,
        "path": "http://localhost:8000/api/transactions",
        "per_page": 10,
        "prev_page_url": null,
        "to": 1,
        "total": 1
    }
}

##Report

###GET /reports/low-stock

Response 200
{
    "success": true,
    "data": [
        {
            "id": 2,
            "category_id": 4,
            "supplier_id": 2,
            "name": "Pizza",
            "sku": "PZZ",
            "price": "28000.00",
            "stock": 0,
            "min_stock": 1,
            "image_path": "images/BNkNAweZh0V1dGyBhpIt0LX2z7GDnRd91hvzJNNj.jpg",
            "is_active": 0,
            "created_at": "2026-07-13T02:26:27.000000Z",
            "updated_at": "2026-07-13T16:27:58.000000Z",
            "deleted_at": null,
            "category": null,
            "supplier": {
                "id": 2,
                "name": "Nafis",
                "email": "nafis@gmail.com",
                "phone": "0895391622424",
                "address": "Ngadirno Klero, rt15 rw 04",
                "created_at": "2026-07-11T08:49:34.000000Z",
                "updated_at": "2026-07-11T08:49:34.000000Z",
                "deleted_at": null
            }
        }
    ]
}

###GET /reports/export

Response 200
{
    "success": true,
    "message": "Export sedang di proses"
}

###GET /reports/export/download

Response 200
Body : 
Name,Sku,Price,Stock
Pizza,PZZ,28000.00,0
Buggle,BGL,18000.00,0
"Veggie Salad",P-CXT,52691.00,7
"Chicken Sandwich",P-ZLA,35764.00,0
"Chicken Burger",P-8HH,91283.00,53
"Veggie Burger",P-LJL,15956.00,83
"Cheese Rice Bowl",P-T5A,28879.00,59
"Chicken Salad",P-8AS,27468.00,4
"Cheese Rice Bowl",P-ZIJ,50572.00,93
"Veggie Sandwich",P-FTL,61131.00,50
"Cheese Pizza",P-FYH,36319.00,79
"Fish Rice Bowl",P-UIF,38755.00,0
