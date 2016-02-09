#Script to convert the list of majors in majors.txt to an HTML list

#Input File
infile = open("majors.txt", "r")

#Output File
outfile = open("majors.html","w")

outfile.write("<select>\n")

for line in infile:
    major = line.strip("\n")
    outfile.write("    <option value=\"%s\">%s</option>\n" % (major, major))

outfile.write("</select>\n")

infile.close()
outfile.close()
