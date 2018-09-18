%.pdf: %.md
	pandoc -V papersize:a4 -V geometry:"top=0.2cm, bottom=5cm, left=2cm, right=2cm" -H inc/header.tex -t latex -o $@ $^
