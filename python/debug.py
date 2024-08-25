from src.scrapper import Scrapper

def main():
    url = "https://canvas.playinzoi.com/en-US/gallery/gal-240817-103657-9960000"
    url = "https://canvas.playinzoi.com/en-US/gallery/gal-240815-091552-2620000"

    DEBUG = False

    output = Scrapper(url=url, debug=DEBUG).scrap()

    print(output)


if __name__ == "__main__":
    main()
