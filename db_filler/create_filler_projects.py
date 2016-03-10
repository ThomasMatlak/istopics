import csv

infile = open("ISkeywords.csv", "r")
outfile = open("filler_projects.sql", "w")

reader = csv.reader(infile)
for row in reader:
    title = row[0]
    discipline = row[1]
    keywords = row[2]

    output = 'INSERT INTO projects (title, keywords, discipline) VALUES ("%s","%s","%s");\n' % (title, keywords, discipline)
    outfile.write(output)

infile.close()
outfile.close()
