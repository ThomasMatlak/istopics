#import random

outfile = open("filler_user_project_connections.sql", "w")

for i in range(1084):
    user_id = 8 # Change this to whatever user id you want (every project will belong to them), or you could randomize the user id by uncommenting the line below and setting this to the max user id
    #user_id = randrange(1, user_id + 1)
    last_proj_id = 0 # Change this to the last project currently in the database (0 if having just run TRUNCATE on the projects table)

    output = "INSERT INTO user_project_connections (userid, projectid) VALUES (%i, %i);\n" % (user_id, (i + last_proj_id  + 1))
    outfile.write(output)

outfile.close()
