<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Weather App</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
            transition: 0.5s ease-in-out;
        }

        /* Default */
        body.default-weather {
            background: linear-gradient(135deg, #74ebd5, #9face6);
        }

        /* Cold weather */
        body.cold-weather {
            background: linear-gradient(135deg, #83a4d4, #b6fbff);
        }

        /* Moderate weather */
        body.moderate-weather {
            background: linear-gradient(135deg, #89f7fe, #66a6ff);
        }

        /* Hot weather */
        body.hot-weather {
            background: linear-gradient(135deg, #f7971e, #ffd200);
        }

        .weather-card {
            width: 100%;
            max-width: 520px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 25px;
            padding: 35px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            transition: 0.5s ease-in-out;
        }

        .weather-icon {
            font-size: 70px;
            margin-bottom: 15px;
            transition: 0.5s ease-in-out;
        }

        .cold-weather .weather-icon {
            color: #0dcaf0;
        }

        .moderate-weather .weather-icon {
            color: #0d6efd;
        }

        .hot-weather .weather-icon {
            color: #ff7b00;
        }

        .form-control {
            border-radius: 15px;
            padding: 14px 18px;
        }

        .btn-search {
            border-radius: 15px;
            padding: 13px;
            font-weight: bold;
        }

        #temp {
            font-weight: bold;
        }

        .cold-weather #temp {
            color: #0dcaf0;
        }

        .moderate-weather #temp {
            color: #0d6efd;
        }

        .hot-weather #temp {
            color: #ff7b00;
        }

        #cityName {
            font-size: 22px;
            font-weight: 600;
            color: #333;
        }

        #weatherStatus {
            font-size: 20px;
            font-weight: bold;
            margin-top: 5px;
        }

        .weather-info {
            display: none;
        }

        .info-box {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 15px;
            margin-top: 15px;
        }
    </style>
</head>

<body class="default-weather">

    <div class="weather-card text-center">
        <i id="mainIcon" class="fa-solid fa-cloud-sun weather-icon"></i>

        <h2 class="mb-2">Weather App</h2>
        <p class="text-muted mb-4">Search for any city weather</p>

        <form onsubmit="getWeather(event)" id="weather-form">
            <div class="input-group mb-3">
                <input type="text" name="weather" id="weather" class="form-control form-control-lg"
                    placeholder="Type city name...">

                <button class="btn btn-primary btn-search" type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>

            <div class="text-center mt-3">
                <i id="loader" class="fas fa-spinner fa-spin d-none fs-3 text-primary"></i>
            </div>
        </form>

        <div class="weather-info" id="weatherInfo">
            <div id="cityName" class="mt-4"></div>

            <h2 class="display-3 text-center mt-2" id="temp"></h2>

            <div id="weatherStatus"></div>

            <div class="info-box">
                <div class="row">
                    <div class="col-6">
                        <i class="fa-solid fa-wind text-primary"></i>
                        <p class="mb-0">Wind</p>
                        <strong id="wind"></strong>
                    </div>

                    <div class="col-6">
                        <i class="fa-solid fa-droplet text-primary"></i>
                        <p class="mb-0">Humidity</p>
                        <strong id="humidity"></strong>
                    </div>
                </div>
            </div>
        </div>

        <div id="message" class="mt-4 fw-bold"></div>
    </div>

    <script>
        function getWeather(event) {
            event.preventDefault();

            let city = document.querySelector("#weather").value;
            let temp = document.querySelector("#temp");
            let loader = document.querySelector("#loader");
            let message = document.querySelector("#message");
            let weatherInfo = document.querySelector("#weatherInfo");
            let cityName = document.querySelector("#cityName");
            let wind = document.querySelector("#wind");
            let humidity = document.querySelector("#humidity");
            let mainIcon = document.querySelector("#mainIcon");
            let weatherStatus = document.querySelector("#weatherStatus");

            if (city.trim() === "") {
                message.innerHTML = "Please enter city name";
                message.className = "mt-4 fw-bold text-danger";
                weatherInfo.style.display = "none";
                return;
            }

            loader.classList.remove("d-none");
            message.innerHTML = "";
            weatherInfo.style.display = "none";

            let url = "https://api.openweathermap.org/data/2.5/weather?q=" +
                city +
                "&appid=2248dc01edb7990be8e8afaa1a58b2c8&units=metric";

            axios.get(url)
                .then((res) => {
                    let temperature = Math.round(res.data.main.temp);

                    cityName.innerHTML = res.data.name;
                    temp.innerHTML = temperature + " °C";
                    wind.innerHTML = res.data.wind.speed + " m/s";
                    humidity.innerHTML = res.data.main.humidity + " %";

                    changeWeatherDesign(temperature, mainIcon, weatherStatus);

                    weatherInfo.style.display = "block";
                })
                .catch((err) => {
                    console.log(err.response);

                    if (err.response && err.response.status === 401) {
                        message.innerHTML = "API Key is invalid or not activated yet";
                    } else if (err.response && err.response.status === 404) {
                        message.innerHTML = city + " not found";
                    } else {
                        message.innerHTML = "Something went wrong";
                    }

                    message.className = "mt-4 fw-bold text-danger";
                    weatherInfo.style.display = "none";
                })
                .finally(() => {
                    loader.classList.add("d-none");
                });
        }

        function changeWeatherDesign(temperature, mainIcon, weatherStatus) {
            document.body.classList.remove("default-weather", "cold-weather", "moderate-weather", "hot-weather");

            if (temperature < 10) {
                document.body.classList.add("cold-weather");
                mainIcon.className = "fa-solid fa-snowflake weather-icon";
                weatherStatus.innerHTML = "Cold Weather ❄️";
            } else if (temperature <= 25) {
                document.body.classList.add("moderate-weather");
                mainIcon.className = "fa-solid fa-cloud-sun weather-icon";
                weatherStatus.innerHTML = "Moderate Weather 🌤️";
            } else {
                document.body.classList.add("hot-weather");
                mainIcon.className = "fa-solid fa-sun weather-icon";
                weatherStatus.innerHTML = "Hot Weather ☀️";
            }
        }
    </script>

</body>

</html>
