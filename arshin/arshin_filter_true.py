# -*- coding: utf-8 -*-
import mysql.connector as mariadb
from mysql.connector import Error
import datetime
import io
import webbrowser,time
from selenium import webdriver
import chromedriver_binary
from selenium.webdriver.common.keys import Keys
from selenium.common.exceptions import NoSuchElementException
from selenium.webdriver.common.desired_capabilities import DesiredCapabilities
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import NoSuchElementException
import sys
import time

print('open log.txt')
with io.open('log.txt', 'a', encoding='utf-8') as f:
	date_end = datetime.datetime.strptime(sys.argv[1], '%d-%m-%Y %H:%M')
	date_start = date_end
	date_now = datetime.datetime.now()
	f.write(date_now.strftime("%d.%m.%Y %H:%M") + ":".decode('utf-8'))
	f.write("  arshin_filter_true.py\n".decode('utf-8'))
	options = webdriver.ChromeOptions()
	options.add_argument('--headless')

	ct = 0
	attempts = 3
	for ct in range(attempts):
		f.write('    webdriver.Remote\n'.decode('utf-8'))
		browser = webdriver.Remote("http://ximko-4:4444/wd/hub", DesiredCapabilities.CHROME)
		try:
			print("try "+ str(ct + 1)+" ...")
			f.write("    try "+ str(ct + 1)+" ...\n".decode('utf-8'))

			print('browser.get')
			f.write("    browser.get\n".decode('utf-8'))
			browser.get ('https://fgis.gost.ru/fundmetrology/cm/results?filter_mi_mitnumber=14531&filter_verification_date_start=' + date_start.strftime("%Y-%m-%d") + '&filter_verification_date_end=' + date_end.strftime("%Y-%m-%d") + '&filter_applicability=true&sort=result_docnum%7Casc&rows=100')
			browser.implicitly_wait(30)
			print('implicitly_wait')
			
			print('find_element...')
			content = browser.find_element_by_css_selector('body > div > div > div.content > div > div > div.col-md-34.col-sm-36 > div:nth-child(4) > div.table-responsive.data-data.sticky-spinner-wrap.canShow > table > tbody')

			print('find_element_by_css_selector.')
			f.write("    find_element_by_css_selector\n".decode('utf-8'))
			texts = []

			content_tr = content.find_elements('xpath',"//tr[starts-with(@id,'item_1')]")

			print("find_elements('xpath','//tr')")

			for e in content_tr:
				txt = []
				for ee in e.find_elements_by_css_selector('td'):
					txt.append(ee.get_attribute("innerText").encode('utf-8'))
				texts.append(txt)

			print('date_start: ' + date_start.strftime("%d.%m.%Y"))
			print('date_end: ' + date_end.strftime("%d.%m.%Y"))
			f.write('    date_start: ' + date_start.strftime("%d.%m.%Y") + ' date_end: ' + date_end.strftime("%d.%m.%Y") + '\n'.decode('utf-8'))

			browser.close()

			print('browser done.')
			f.write("    browser done.\n".decode('utf-8'))


			conn = mariadb.connect(user="###",password="###",database="###",host="###",port=000)

			print('Connected arshin.')
			insert_count = 0
			update_count = 0
			f.write("    Connected arshin.\n".decode('utf-8'))
			for i in range(len(texts)):
				date_now = datetime.datetime.now()
				cur = conn.cursor()
				if (i == 1):
					f.write('    test texts: [1][0]=' + texts[1][0].decode('utf-8') + '; [1][1]=' + texts[1][1].decode('utf-8') + '; [1][2]=' + texts[1][2].decode('utf-8') + '; [1][3]=' + texts[1][3].decode('utf-8') + '; [1][4]=' + texts[1][4].decode('utf-8') + '; [1][5]=' + texts[1][5].decode('utf-8') + '; [1][6]=' + texts[1][6].decode('utf-8') + '; [1][7]=' + texts[1][7].decode('utf-8') + '; [1][8]=' + texts[1][8].decode('utf-8') + '\n'.decode('utf-8'))

				cur.execute("SELECT * FROM arshin WHERE poveritel = '"+texts[i][0]+"' AND reg_nbr='"+texts[i][1]+"' AND name_ci='"+texts[i][2]+"' AND type_ci='"+texts[i][3]+"' AND modif_ci='"+texts[i][4]+"' AND nb_pribor='"+texts[i][5]+"' AND cv_nbr='"+texts[i][8]+"'")
				rows = cur.fetchall()
				if (len(rows) == 0):
					cur.execute("INSERT INTO arshin(id, poveritel, reg_nbr, name_ci, type_ci, modif_ci, nb_pribor, date_poverka, date_poverka_end, cv_nbr, goden, date_add) VALUES (NULL,'"+texts[i][0]+"','"+texts[i][1]+"','"+texts[i][2]+"','"+texts[i][3]+"','"+texts[i][4]+"','"+texts[i][5]+"',STR_TO_DATE('"+texts[i][6]+"', '%e.%m.%Y'),STR_TO_DATE('"+texts[i][7]+"', '%e.%m.%Y'),'"+texts[i][8]+"','da', '"+date_now.strftime("%d.%m.%Y %H:%M")+"')")
					conn.commit()
					insert_count = insert_count + 1
				else:
					for row in rows:
						cur.execute("UPDATE arshin SET date_poverka=STR_TO_DATE('"+texts[i][6]+"', '%e.%m.%Y'), date_poverka_end=STR_TO_DATE('"+texts[i][7]+"', '%e.%m.%Y'), goden='da', date_add='"+date_now.strftime("%d.%m.%Y %H:%M")+"' WHERE id='"+str(row[0])+"'")
						conn.commit()
						update_count = update_count + 1
				cur.close()
			conn.close()
			print("INSERT INTO arshin. count = " + str(insert_count) +"    UPDATE arshin. count = "+str(update_count)+" done.")
			f.write("    INSERT INTO arshin. count = " + str(insert_count) +"    UPDATE arshin. count = "+str(update_count)+" done.\n".decode('utf-8'))
			print("exit OK.")
			f.write("    exit OK.\n".decode('utf-8'))
			exit(0)
		except mariadb.Error:
			print ("ERROR IN CONNECTION SQL")
			f.write("    ERROR IN CONNECTION SQL\n".decode('utf-8'))
			f.close()
			exit(-1)
		except Exception as exc:
			print(exc)
			print("error!")
			f.write("    error! "+str(exc).decode('utf-8'))
			print("wait 5s ...")
			f.write("    wait 5s ...\n".decode('utf-8'))
			time.sleep(5)
		else:
			exit(0)
		finally:
			browser.quit()
			print("finally exit.")
			f.write("    finally exit.\n".decode('utf-8'))
	f.close()
	exit(0)