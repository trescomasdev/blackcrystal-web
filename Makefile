all:
	@echo "Doing all"

deploy:
	@echo "Pushing to production"
	@git push blackcrystal@blackcrystalshop.uk:~/blackcrystal master

update:
	@echo "Makefile: Doing UPDATE stuff like grunt, gulp, rake,..."
	@whoami
	@pwd
