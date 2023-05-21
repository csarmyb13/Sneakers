import requests
from bs4 import BeautifulSoup
import mysql.connector

conn = mysql.connector.connect(
    host = "localhost",
    user = "root",
    password = "",
    database = "sneakers",
    auth_plugin='mysql_native_password'
    )

c = conn.cursor()

c.execute('SELECT * FROM shoes WHERE brand = %s AND style = %s', ('Adidas', ''))
c.fetchall()


source = requests.get('https://sneakers123.com/en/models').text

soup = BeautifulSoup(source, 'lxml')

for all_models in soup.find_all('article', class_='container-fluid models'):
    # grabs first shoe model name
    shoes = all_models.h2.a.text
    print(shoes)

    # grabs first shoe model count
    brand_count = all_models.find('span', class_='brand-count').text
    print(brand_count)

    # loop through all shoe names
    for shoe_name in all_models.div.ul.find_all('li'):
        # grabs shoe name
        name = shoe_name.a.text
        # grabs shoe style count
        style_count = shoe_name.find('span', class_='cat-count').text
        if int(style_count) >= 1:
            print(name)
            print(style_count)
            sql = "INSERT INTO sneakers_adidas (shoes, brand_count, name, style_count) VALUES (%s, %s, %s, %s)"
            val = (shoes, brand_count, name, int(style_count))
            c.execute(sql, val)
            
conn.commit()
conn.close()
