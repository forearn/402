#!/Python27/python.exe
# -*- coding: utf-8 -*-
"""
Created on Mon Feb 29 16:40:50 2016

@author: wgs01
"""

import psycopg2
import cgi
import cgitb; cgitb.enable()
from datetime import datetime

form = cgi.FieldStorage()
conn = psycopg2.connect(database="DB_test", user="postgres", password="1234", host="localhost", port="5432")
cur = conn.cursor()

def main():
    print "Content-type: text/html\n"
    print "\n\n"
    
    typeStatic = ""
    query = ""
    json = "["

    for i in form.keys():
        if i == "typeStatic":
            typeStatic = form[i].value
             
    
    querySelect = "SELECT \"post_Name\", ST_X(ST_GeomFromText(ST_AsText(\"post_GeomIncident\"),4326)), ST_Y(ST_GeomFromText(ST_AsText(\"post_GeomIncident\"),4326)), \"post_Date\", \"post_Status\", \"post_Message\", \"post_Hashtag\" FROM \"table_postTWH\";";
#    querySelect = "SELECT \"staticDataLayer_sql\" FROM \"table_staticDataLayer\" WHERE \"staticDataLayer_Name\" = 'Police station';";
    cur.execute(querySelect)
    rows = cur.fetchall()
    count = 0
    for row in rows:        
        if count == len(rows)-1 :
            json = json + "{\"name\":\"" + row[0] + "\",\"long_itude\":\"" + str(row[1]) + "\",\"lat_itude\":\"" + str(row[2]) + "\"}]"
        else:
            json = json + "{\"name\":\"" + row[0] + "\",\"long_itude\":\"" + str(row[1]) + "\",\"lat_itude\":\"" + str(row[2]) + "\"},"
        count +=1
    

    conn.close()
    print json

if __name__ == '__main__':
    main()