CONSOLE := bin/console

dfl: 
	$(CONSOLE) d:d:d --force && $(CONSOLE) d:d:c && $(CONSOLE) d:s:u --force && $(CONSOLE) d:f:l
