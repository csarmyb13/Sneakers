import requests
from bs4 import BeautifulSoup


source = requests.get('https://sneakers123.com/en/models').text

soup = BeautifulSoup(source, 'lxml')

for all_div in soup.find_all('div', class_='line'):
    # grabs first shoe model name
    shoes = all_div.h1.h2.a.text
    print(shoes)

    # grabs first shoe model count
    brand_count = all_div.find('span', class_='brand-count').text
    print(brand_count)

    # loop through all shoe names
    for shoe_name in all_div.div.ul.find_all('li'):
        # grabs shoe name
        name = shoe_name.a.text
        # grabs shoe style count
        style_count = shoe_name.find('span', class_='cat-count').text
        if int(style_count) >= 1:
            print(name)
            print(style_count)
            