<div class="first-child-2">
    <div class="progress-bars">
        <div class="graph">
            <div class="outer">
                <div class="inner">
                    <div id="number"></div>
                </div>
            </div>
            <svg id="overall-progress-svg" xmlns="http://www.w3.org/2000/svg" version="1.1" width="160px"
                height="160px">
                <defs>
                    <linearGradient id="GradientColor">
                        <stop offset="0%" stop-color="#e91e63" />
                        <stop offset="100%" stop-color="#673ab7" />
                    </linearGradient>
                </defs>
                <circle id="circle" cx="100" cy="100" r="90" stroke-linecap="round" />
            </svg>
        </div>
        <div class="sub-progress-bar">
            <div class="planning-bar-graph">
                <div class="planning-bar-outer">
                    <div class="planning-bar-inner">
                        <div id="planning-bar-number"></div>
                    </div>
                </div>
                <svg id="planning-svg-bar" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100px"
                    height="100px">
                    <defs>
                        <linearGradient id="planning-bar-gradient">
                            <stop offset="0%" stop-color="#e91e63" />
                            <stop offset="100%" stop-color="#673ab7" />
                        </linearGradient>
                    </defs>
                    <circle class="planning-circle" id="sub-bar-circle" cx="50" cy="50" r="40" stroke-linecap="round" />
                </svg>
            </div>
            <div class="planning-bar-graph">
                <div class="planning-bar-outer">
                    <div class="planning-bar-inner">
                        <div id="design-bar-number"></div>
                    </div>
                </div>
                <svg id="planning-svg-bar" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100px"
                    height="100px">
                    <defs>
                        <linearGradient id="planning-bar-gradient">
                            <stop offset="0%" stop-color="#e91e63" />
                            <stop offset="100%" stop-color="#673ab7" />
                        </linearGradient>
                    </defs>
                    <circle class="design-circle" id="sub-bar-circle" cx="50" cy="50" r="40" stroke-linecap="round" />
                </svg>
            </div>
            <div class="planning-bar-graph">
                <div class="planning-bar-outer">
                    <div class="planning-bar-inner">
                        <div id="development-bar-number"></div>
                    </div>
                </div>
                <svg id="planning-svg-bar" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100px"
                    height="100px">
                    <defs>
                        <linearGradient id="planning-bar-gradient">
                            <stop offset="0%" stop-color="#e91e63" />
                            <stop offset="100%" stop-color="#673ab7" />
                        </linearGradient>
                    </defs>
                    <circle class="development-circle" id="sub-bar-circle" cx="50" cy="50" r="40"
                        stroke-linecap="round" />
                </svg>
            </div>
            <div class="planning-bar-graph">
                <div class="planning-bar-outer">
                    <div class="planning-bar-inner">
                        <div id="testing-bar-number"></div>
                    </div>
                </div>
                <svg id="planning-svg-bar" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100px"
                    height="100px">
                    <defs>
                        <linearGradient id="planning-bar-gradient">
                            <stop offset="0%" stop-color="#e91e63" />
                            <stop offset="100%" stop-color="#673ab7" />
                        </linearGradient>
                    </defs>
                    <circle class="testing-circle" id="sub-bar-circle" cx="50" cy="50" r="40" stroke-linecap="round" />
                </svg>
            </div>
        </div>
        <div class="list-of-progress-name">
            <ul class="dot-list">
                <li class="dot-list-item"><span class="dot red"></span>Planning</li>
                <li class="dot-list-item"><span class="dot light-blue"></span>Design</li>
                <li class="dot-list-item"><span class="dot blue"></span>Development</li>
                <li class="dot-list-item"><span class="dot purple"></span>Testing</li>
            </ul>
        </div>
    </div>

</div>

<script>
//get the number inside the overall progress bar
const progressBars = [{
        element: $("#number"),
        maxPercentage: 30,
        interval: 60
    },
    {
        element: $("#planning-bar-number"),
        maxPercentage: 87,
        interval: 20
    },
    {
        element: $("#design-bar-number"),
        maxPercentage: 70,
        interval: 25
    },
    {
        element: $("#development-bar-number"),
        maxPercentage: 40,
        interval: 40
    },
    {
        element: $("#testing-bar-number"),
        maxPercentage: 10,
        interval: 80
    }
];

const updateProgress = (bar) => {
    let counter = 0;
    let time_interval;
    const intervalId = setInterval(() => {
        if (counter >= bar.maxPercentage) {
            clearInterval(intervalId);
        } else {
            counter++;
            bar.element.html(counter + "%");
        }
    }, bar.interval);
    bar.intervalId = intervalId;
};

progressBars.forEach(updateProgress);
</script>