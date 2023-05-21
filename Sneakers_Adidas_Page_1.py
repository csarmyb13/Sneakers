import requests
from bs4 import BeautifulSoup
import mysql.connector

conn = mysql.connector.connect(
    host = "localhost",
    user = "root",
    password = "Ctmdsbggpn900!!",
    database = "sneakers",
    auth_plugin='mysql_native_password'
    )

c = conn.cursor()

c.execute('SELECT * FROM sneakers_adidas_superstar WHERE brand_name = %s AND style_name = %s', ('Adidas', ''))
c.fetchall()


source = requests.get('https://sneakers123.com/en/sneaker/?category=Adidas%20Superstar').text

soup = BeautifulSoup(source, 'lxml')

for all_styles in soup.find_all('div', class_='product-names'):
    shoes = all_styles.text
    print(shoes)

    #grabs brand name
    brand_name = all_styles.find('div', class_='product-title').text
    print(brand_name)

    #grabs name of shoe
    style_name = all_styles.find('div', class_='product-series').text
    print(style_name)

    #grabs product ID
    product_id = all_styles.find('div', class_='product-mark').text
    print(product_id)
    sql = "INSERT INTO sneakers_adidas_superstar (shoes, brand_name, style_name, id) VALUES (%s, %s, %s, %s)"
    val = (shoes, brand_name, style_name, product_id)
    c.execute(sql, val)
            
conn.commit()
conn.close()