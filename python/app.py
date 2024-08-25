from flask import Flask, request, jsonify

from src.scrapper import Scrapper

app = Flask(__name__)

@app.route("/")
def scrap():
    url = request.args.get("url", None)

    if url is None:
        return jsonify({"error": "URL is required"}), 400

    expected = "https://canvas.playinzoi.com/en-US/gallery"

    if expected not in url:
        return jsonify({"error": f"URL must contain {expected}"}), 400

    try:
        output = Scrapper(url=url).scrap()
    except Exception as e:
        return jsonify({"error": str(e)}), 400

    return jsonify(output), 200

