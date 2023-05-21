import requests
from bs4 import BeautifulSoup
import mysql.connector

conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="Ctmdsbggpn900!!",
    database="sneakers",
    auth_plugin='mysql_native_password'
)

c = conn.cursor()

c.execute('SELECT * FROM adidas_superstar_eg4958 WHERE date_sold = %s AND price = %s', ('', ''))
_ = c.fetchall()

source = requests.get('https://www.ebay.com/sch/i.html?_from=R40&_nkw=Adidas+Originals+Men%27s+Superstar+Shoes+White%2FBlack+EG4958+H&_sacat=0&LH_Sold=1&LH_Complete=1&rt=nc&LH_ItemCondition=3').text

soup = BeautifulSoup(source, 'lxml')

dates_prices = []

# iterate over the parent elements containing both date and price
for item in soup.find_all('li', class_='s-item s-item__pl-on-bottom'):
    # get the sale date
    date_sold = item.find('div', class_='s-item__title--tag').span.text[5:18]
    
    # get the price sold for
    price = item.find('span', class_='s-item__price').text
    
    # append the date and price as a tuple
    dates_prices.append((date_sold, price))

# makes sure there is a matching date and price  
if len(dates_prices) > 0:
    sql = "INSERT INTO adidas_superstar_eg4958 (date_sold, price) VALUES (%s, %s)"
    c.executemany(sql, dates_prices)
    print(dates_prices)

conn.commit()
conn.close()
