import time

from selenium import webdriver
from selenium.webdriver.firefox.options import Options


class Timer:
    def start(self):
        self.start_time = time.time()

    def end(self):
        self.end_time = time.time()

    def diff(self):
        return self.end_time - self.start_time


class Engine:
    def __init__(self, debug: bool = False):
        print("@init web driver")

        self.options = Options()

        if not debug:
            self.options.add_argument("--headless")

        self.driver = webdriver.Firefox(options=self.options)

    def __del__(self):
        print("@kill web driver")
        self.driver.quit()
        del self.driver


class Scrapper:
    def __init__(self, url: str, debug: bool = False):
        self.url = url

        self.engine = Engine(debug=debug)

    def debug(self, element):
        with open("debug.html", "w") as f:
            f.write(element.get_attribute("outerHTML"))

    def scrap(self) -> dict:
        timer = Timer()
        timer.start()

        self.engine.driver.get(self.url)

        time.sleep(1)

        images_wrapper = self.engine.driver.find_elements(
            "xpath", "//img[@alt='gallery detail']"
        )
        images = []
        for image in images_wrapper:
            images.append(image.get_attribute("src"))

        wrapper = self.engine.driver.find_element(
            "xpath", "//div[@class='w-[500px] flex-shrink-0']"
        )

        creation_date = wrapper.find_element(
            "xpath",
            ".//p[@class='flex flex-shrink-0 text-2xs font-medium leading-[24px] text-gray-600']",
        ).text.replace(".", "-")
        title = wrapper.find_element(
            "xpath", ".//p[@class='break-words text-[40px] font-bold']"
        ).text
        description = wrapper.find_element(
            "xpath",
            ".//p[@class='mt-3 whitespace-pre-wrap break-words text-xs leading-[24px] text-gray-700']",
        ).text

        download_button = wrapper.find_element(
            "xpath",
            "//button[@class='flex w-full items-center justify-center gap-1 rounded-[30px] bg-blue-500 py-2 text-xs font-semibold']",
        )
        download_count = download_button.find_element("xpath", ".//p").text.replace(
            "Download ", ""
        )
        download_count = download_count.replace("K", "00").replace(".", "")

        like_button = wrapper.find_element(
            "xpath",
            "//button[@class='flex w-full items-center justify-center gap-1 rounded-[30px] border border-[#E3E3E3] text-xs font-semibold']",
        )
        like_count = like_button.find_element("xpath", ".//p").text
        like_count = like_count.replace("K", "00").replace(".", "")

        wrappers = wrapper.find_elements(
            "xpath",
            "//div[@class='undefined flex flex-col rounded-[10px] border border-gray-400 p-[30px]']",
        )

        creator_wrapper = wrappers[0].find_element(
            "xpath",
            ".//div[@class='flex items-center gap-1']",
        ).find_element(
            "xpath",
            ".//div[@class='w-full']"
        ).find_element(
            "xpath",
            ".//div[@class='flex justify-between']"
        ).find_element(
            "xpath",
            ".//a[@class='flex']"
        )
        creator_profile_url = creator_wrapper.get_attribute("href")

        try:
            creator_image_url = creator_wrapper.find_element(
                "xpath",
                ".//img[@alt='profile']",
            ).get_attribute("src")
        except:
            creator_image_url = None

        creator_name = creator_wrapper.find_element(
            "xpath",
            ".//p[@class='text-xs font-semibold']"
        ).get_attribute("innerHTML")

        timer.end()
        print(f"Execution time: {timer.diff()}s")

        return {
            "url": self.url,
            "title": title,
            "description": description,
            "publication_date": creation_date,
            "creator": {
                "profile_url": creator_profile_url,
                "avatar_url": creator_image_url,
                "name": creator_name
            },
            "stats": {
                "downloads": int(download_count),
                "likes": int(like_count),
            },
            "images": images,
        }
