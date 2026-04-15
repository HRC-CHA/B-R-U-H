<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B.R.U.H. - Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Faculty+Glyphic&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style type="text/tailwindcss">
        @layer base {
          :root {
            --background: 150 15% 10%;
            --foreground: 80 20% 90%;
            --card: 150 12% 14%;
            --card-foreground: 80 20% 90%;
            --popover: 150 12% 14%;
            --popover-foreground: 80 20% 90%;
            --primary: 143 35% 48%;
            --primary-foreground: 0 0% 100%;
            --secondary: 150 12% 18%;
            --secondary-foreground: 80 20% 85%;
            --muted: 150 10% 18%;
            --muted-foreground: 150 8% 55%;
            --accent: 143 20% 20%;
            --accent-foreground: 143 30% 65%;
            --destructive: 0 65% 50%;
            --destructive-foreground: 0 0% 100%;
            --warning: 30 85% 50%;
            --warning-foreground: 0 0% 100%;
            --border: 150 10% 20%;
            --input: 150 10% 20%;
            --ring: 143 35% 48%;
            --radius: 0.75rem;
            --font-heading: 'Faculty Glyphic', serif;
            --font-body: 'Inter', sans-serif;
          }
          
          body { @apply bg-background text-foreground; font-family: var(--font-body); }

          h1, h2, h3, h4, h5, h6, select {
            font-family: var(--font-heading);
            letter-spacing: -0.01em;
          }
        }
        select { -webkit-appearance: none; -moz-appearance: none; appearance: none; }
    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        border: "hsl(var(--border))",
                        input: "hsl(var(--input))",
                        ring: "hsl(var(--ring))",
                        background: "hsl(var(--background))",
                        foreground: "hsl(var(--foreground))",
                        primary: { DEFAULT: "hsl(var(--primary))", foreground: "hsl(var(--primary-foreground))" },
                        secondary: { DEFAULT: "hsl(var(--secondary))", foreground: "hsl(var(--secondary-foreground))" },
                        destructive: { DEFAULT: "hsl(var(--destructive))", foreground: "hsl(var(--destructive-foreground))" },
                        muted: { DEFAULT: "hsl(var(--muted))", foreground: "hsl(var(--muted-foreground))" },
                        accent: { DEFAULT: "hsl(var(--accent))", foreground: "hsl(var(--accent-foreground))" },
                        card: { DEFAULT: "hsl(var(--card))", foreground: "hsl(var(--card-foreground))" },
                        warning: { DEFAULT: "hsl(var(--warning))", foreground: "hsl(var(--warning-foreground))" },
                    },
                    fontFamily: {
                        heading: ['"Faculty Glyphic"', "serif"],
                        body: ['"Inter"', "sans-serif"],
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-background text-foreground relative">

    <nav class="bg-card border-b border-border px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between relative z-50">
        <div class="flex items-center gap-8">
            <div class="flex items-center gap-2 cursor-pointer" onclick="window.location.href='/dashboard'">
                <i data-lucide="leaf" class="h-6 w-6 text-primary"></i>
                <span class="font-extrabold text-xl tracking-tight text-foreground" style="font-family: var(--font-heading);">B.R.U.H.</span>
            </div>
            <div class="hidden md:flex items-center gap-1">
                <a href="/dashboard" class="flex items-center gap-2 px-3 py-2 rounded-md text-sm font-medium bg-primary/10 text-primary transition-colors">
                    <i data-lucide="layout-dashboard" class="h-4 w-4"></i> Dashboard
                </a>
                <a href="/track" class="flex items-center gap-2 px-3 py-2 rounded-md text-sm font-medium text-muted-foreground hover:text-foreground hover:bg-muted transition-colors">
                    <i data-lucide="clipboard-list" class="h-4 w-4"></i> Track & Manage
                </a>
                <a href="/settings" class="flex items-center gap-2 px-3 py-2 rounded-md text-sm font-medium text-muted-foreground hover:text-foreground hover:bg-muted transition-colors">
                    <i data-lucide="settings" class="h-4 w-4"></i> Settings
                </a>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <div class="hidden md:flex items-center gap-4">
                <span class="text-sm text-muted-foreground">Hello, <span class="font-bold text-foreground"><?= $username ?></span></span>
                <div class="w-px h-4 bg-border"></div> 
                <a href="/auth/logout" class="text-sm text-destructive hover:opacity-80 transition-colors flex items-center gap-1.5">
                    <i data-lucide="log-out" class="h-4 w-4"></i> <span class="font-bold">Logout</span>
                </a>
            </div>

            <button onclick="toggleMobileMenu()" class="md:hidden p-2 text-muted-foreground hover:text-foreground rounded-md transition-colors focus:outline-none">
                <i data-lucide="menu" id="menu-icon" class="h-6 w-6"></i>
            </button>
        </div>

        <div id="mobile-menu" class="hidden absolute top-16 left-0 w-full bg-card border-b border-border shadow-2xl md:hidden">
            <div class="px-4 pt-2 pb-6 space-y-2">
                <a href="/dashboard" class="block px-4 py-3 rounded-md text-base font-bold text-primary bg-primary/10 flex items-center gap-3">
                    <i data-lucide="layout-dashboard" class="h-5 w-5"></i> Dashboard
                </a>
                <a href="/track" class="block px-4 py-3 rounded-md text-base font-medium text-foreground hover:bg-muted flex items-center gap-3">
                    <i data-lucide="clipboard-list" class="h-5 w-5"></i> Track & Manage
                </a>
                <a href="/settings" class="block px-4 py-3 rounded-md text-base font-medium text-foreground hover:bg-muted border-b border-border flex items-center gap-3 pb-4">
                    <i data-lucide="settings" class="h-5 w-5"></i> Settings
                </a>
                
                <div class="pt-4 px-4 flex justify-between items-center">
                    <span class="text-sm text-muted-foreground">Hello, <span class="font-bold text-foreground"><?= $username ?></span></span>
                    <a href="/auth/logout" class="flex items-center gap-2 text-sm text-destructive">
                        <i data-lucide="log-out" class="h-4 w-4"></i> <span class="font-bold">Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <?php if($active_spot): ?>
            <div class="bg-card border border-border rounded-2xl shadow-sm overflow-hidden mb-10">
                <div class="flex flex-col lg:flex-row min-h-[340px]">
                    
                    <div class="lg:w-[45%] p-8 lg:p-10 border-b lg:border-b-0 lg:border-r border-border/50 flex flex-col justify-between">
                        <div>
                            <div class="mb-8">
                                <label class="text-[10px] font-bold text-primary uppercase tracking-widest mb-3 block">Current Spot</label>
                                
                                <div class="relative group mt-2">
                                    <select onchange="window.location.href='/dashboard/index/' + this.value;" 
                                            class="w-full bg-secondary/40 border border-border/60 rounded-xl py-4 pl-5 pr-12 text-3xl sm:text-4xl font-bold text-foreground cursor-pointer transition-all hover:bg-secondary hover:border-primary/50 focus:ring-2 focus:ring-primary/20 outline-none">
                                        <?php foreach($spots as $spot): ?>
                                            <option value="<?= $spot->id ?>" <?= $active_spot->id == $spot->id ? 'selected' : '' ?> class="bg-card text-lg">
                                                <?= $spot->name ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-muted-foreground group-hover:text-primary transition-colors">
                                        <i data-lucide="chevron-down" class="h-8 w-8"></i>
                                    </div>
                                </div>

                                <p class="text-sm text-muted-foreground font-medium flex items-center gap-1.5 mt-4 ml-1">
                                    <i data-lucide="map-pin" class="h-4 w-4"></i> 〒<?= $active_spot->display_postal_code() ?>
                                </p>
                            </div>

                            <?php if(!empty($weather)): ?>
                            <div class="flex items-center gap-6 mt-6">
                                <div class="h-20 w-20 rounded-2xl bg-primary/20 flex items-center justify-center text-primary shrink-0">
                                    <i data-lucide="<?= $weather['icon'] ?? 'cloud' ?>" class="h-10 w-10"></i>
                                </div>
                                <div>
                                    <div class="flex items-baseline gap-2">
                                        <h3 class="text-5xl font-extrabold text-foreground"><?= $weather['temp'] ?? '--' ?>°C</h3>
                                        <span class="text-lg font-medium text-muted-foreground">/ <?= $weather['condition'] ?? 'Unknown' ?></span>
                                    </div>
                                    <p class="text-base text-muted-foreground mt-2">
                                        Humidity: <span class="text-foreground font-medium"><?= $weather['humidity'] ?? '--' ?>%</span> 
                                        <span class="mx-3 text-border">|</span> 
                                        Rain: <span class="text-foreground font-medium"><?= $weather['current_rainfall'] ?? '0' ?> mm/h</span>
                                    </p>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="lg:w-[55%] bg-background/30 relative flex flex-col justify-end pt-8 pb-3 overflow-hidden">
                        <div class="absolute top-8 left-8 z-10">
                            <h4 class="text-sm font-bold text-foreground flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-primary animate-pulse shadow-[0_0_8px_rgba(74,222,128,0.6)]"></span>
                                Live Rainfall Forecast
                            </h4>
                            <p class="text-xs text-muted-foreground mt-1">Updates automatically every 10 mins</p>
                        </div>
                        <div id="rainChart" class="w-full h-[280px] px-2 pb-4"></div>
                    </div>
                </div>
            </div>

            <?php if(empty($plants)): ?>
                <div class="text-center py-12 text-muted-foreground bg-background rounded-xl border border-border">
                    <i data-lucide="sprout" class="h-12 w-12 mx-auto mb-3 opacity-50"></i>
                    <p>No plants here yet. Go to Track & Manage to add one!</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach($plants as $plant): ?>
                    <?php 
                        $days_since = floor((time() - $plant->last_watered_at) / (60 * 60 * 24));
                        $bar_color = 'bg-primary';
                        if ($days_since >= 6) $bar_color = 'bg-destructive';
                        elseif ($days_since >= 2) $bar_color = 'bg-warning';
                        $percentage = min(($days_since / 7) * 100, 100);
                        $brightness = max(100 - ($days_since * 7.14), 50);
                    ?>
                    <div class="bg-background border border-border rounded-xl p-5 shadow-sm space-y-4 hover:border-primary/50 transition-all duration-500"
                         style="filter: brightness(<?= $brightness ?>%);" id="plant-card-<?= $plant->id ?>">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
                                <i data-lucide="sprout" class="h-6 w-6 text-primary"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg text-foreground leading-tight"><?= $plant->name ?></h4>
                                <p class="text-sm text-muted-foreground"><?= $plant->species ?></p>
                            </div>
                        </div>
                        
                        <?php 
                            $latest_log = \Model_Growth::find('last', array(
                                'where' => array('plant_id' => $plant->id),
                                'order_by' => array('measured_at' => 'desc')
                            ));
                        ?>
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center rounded-full bg-secondary px-2.5 py-0.5 text-xs font-semibold text-secondary-foreground border border-border">
                                <span class="text-muted-foreground font-normal mr-1">Size:</span> <?= $plant->size ?>
                            </span>
                            
                            <?php if ($latest_log): ?>
                                <span class="inline-flex items-center text-[10px] font-bold text-primary bg-primary/10 px-2 py-0.5 rounded-md border border-primary/20">
                                    <i data-lucide="clock" class="h-3 w-3 mr-1"></i>
                                    Upd: <?= date('M d', $latest_log->measured_at) ?>
                                </span>
                            <?php endif; ?>

                            <span class="inline-flex items-center rounded-full bg-secondary px-2.5 py-0.5 text-xs font-semibold text-secondary-foreground border border-border">
                                <span class="text-muted-foreground font-normal mr-1">Pot:</span> <?= $plant->pot_size ?>
                            </span>
                        </div>

                        <div class="space-y-2">
                            <div class="flex justify-between items-center text-sm font-medium">
                                <span class="text-muted-foreground">Water Status</span>
                                <span id="water-text-<?= $plant->id ?>" class="<?= $days_since >= 6 ? 'text-destructive font-bold' : 'text-foreground' ?>">
                                    <?= $days_since ?> days ago
                                </span>
                            </div>
                            <div class="h-2 w-full overflow-hidden rounded-full bg-secondary">
                                <div id="water-bar-<?= $plant->id ?>" 
                                     class="h-full <?= $bar_color ?> transition-all duration-500" 
                                     style="width: <?= $percentage ?>%"></div>
                            </div>
                        </div>

                        <div class="pt-2">
                            <button type="button" 
                                    id="water-btn-<?= $plant->id ?>"
                                    onclick="waterPlant(event, <?= $plant->id ?>)"
                                    class="w-full inline-flex items-center justify-center rounded-md text-sm font-bold bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 transition-colors shadow-sm">
                                <i data-lucide="droplets" class="h-4 w-4 mr-2"></i> 
                                <span class="btn-text">Water Now!</span>
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="bg-card border border-border rounded-xl p-12 shadow-sm text-center mt-10">
                <i data-lucide="map-pin" class="h-12 w-12 mx-auto mb-3 text-muted-foreground opacity-50"></i>
                <h3 class="text-lg font-semibold text-foreground">Welcome to B.R.U.H!</h3>
                <p class="text-muted-foreground mt-2 mb-6">Go to 'Track & Manage' to create your first Spot.</p>
                <button onclick="window.location.href='/track'" class="inline-flex items-center justify-center rounded-md text-sm font-bold bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 transition-colors">
                    Go to Track & Manage
                </button>
            </div>
        <?php endif; ?>
    </main>

    <script>
        lucide.createIcons();

        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const icon = document.getElementById('menu-icon');
            const isHidden = menu.classList.contains('hidden');
            
            if (isHidden) {
                menu.classList.remove('hidden');
                icon.setAttribute('data-lucide', 'x');
            } else {
                menu.classList.add('hidden');
                icon.setAttribute('data-lucide', 'menu');
            }
            lucide.createIcons();
        }

        let rainChart;
        function initChart(data) {
            if (!data || data.length === 0) return;

            const options = {
                series: [{
                    name: 'Rainfall',
                    data: data.map(item => item.rainfall || 0)
                }],
                chart: {
                    type: 'area',
                    height: '100%',
                    parentHeightOffset: 0,
                    toolbar: { show: false },
                    zoom: { enabled: false },
                    backgroundColor: 'transparent',
                    sparkline: { enabled: false },
                    animations: { enabled: true, easing: 'easeinout', speed: 800 },
                    fontFamily: 'Inter, sans-serif'
                },
                colors: ['#38bdf8'], 
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 3 },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.6,
                        opacityTo: 0.0,
                        stops: [0, 100],
                        colorStops: [
                            { offset: 0, color: "#38bdf8", opacity: 0.5 },
                            { offset: 100, color: "#38bdf8", opacity: 0 }
                        ]
                    }
                },
                xaxis: {
                    type: 'category',
                    categories: data.map(item => item.time || ''), 
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: { 
                        show: true, 
                        rotate: 0, 
                        hideOverlappingLabels: false, 
                        style: { colors: '#94a3b8', fontSize: '11px', fontFamily: 'Inter, sans-serif', fontWeight: 600 }, 
                        offsetY: 2 
                    },
                    tooltip: { enabled: false }
                },
                yaxis: { show: false, min: 0 },
                grid: {
                    show: true,
                    borderColor: 'rgba(255,255,255,0.05)',
                    strokeDashArray: 4,
                    xaxis: { lines: { show: true } },
                    yaxis: { lines: { show: false } },
                    padding: { top: 0, right: 30, bottom: 15, left: 30 }
                },
                tooltip: {
                    theme: 'dark',
                    y: { formatter: (val) => val + " mm/h" },
                    marker: { show: false }
                }
            };

            rainChart = new ApexCharts(document.querySelector("#rainChart"), options);
            rainChart.render();
        }

        async function refreshRainData() {
            <?php if($active_spot): ?>
            try {
                const res = await fetch('/dashboard/rain_data/<?= $active_spot->id ?>');
                const newData = await res.json();
                
                if (rainChart) {
                    rainChart.updateSeries([{ data: newData.map(item => item.rainfall || 0) }]);
                    rainChart.updateOptions({ xaxis: { categories: newData.map(item => item.time || '') } });
                } else {
                    initChart(newData);
                }
            } catch (e) { console.error("Chart sync failed", e); }
            <?php endif; ?>
        }

        document.addEventListener('DOMContentLoaded', () => {
            refreshRainData();
            setInterval(refreshRainData, 600000); 
        });

        function showToast(title, message) {
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-4 right-4 bg-card border border-border text-foreground px-6 py-4 rounded-xl shadow-2xl transition-all duration-300 z-50 opacity-0 translate-y-2 flex flex-col gap-1';
            toast.innerHTML = `
                <div class="font-bold text-sm flex items-center gap-2"><i data-lucide="check-circle-2" class="h-4 w-4 text-primary"></i> ${title}</div>
                <div class="text-xs text-muted-foreground font-normal">${message}</div>
            `;
            document.body.appendChild(toast);
            lucide.createIcons(); 
            setTimeout(() => toast.classList.remove('opacity-0', 'translate-y-2'), 10);
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        }

        async function waterPlant(event, plantId) {
            event.preventDefault(); 
            const btn = document.getElementById(`water-btn-${plantId}`);
            const card = document.getElementById(`plant-card-${plantId}`); 
            const plantName = card.querySelector('h4').innerText;
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<i data-lucide="loader-2" class="h-4 w-4 mr-2 animate-spin"></i> Watering...';
            lucide.createIcons();
            btn.disabled = true;

            try {
                const response = await fetch(`/plant/water/${plantId}`, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                if (response.ok) {
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                    
                    const textElem = document.getElementById(`water-text-${plantId}`);
                    if (textElem) {
                        textElem.innerText = '0 days ago';
                        textElem.className = 'text-foreground';
                    }
                    const barElem = document.getElementById(`water-bar-${plantId}`);
                    if (barElem) {
                        barElem.style.width = '0%';
                        barElem.className = 'h-full bg-primary transition-all duration-500';
                    }
                    
                    if (card) {
                        card.style.filter = 'brightness(100%)';
                    }

                    showToast('Watered!', `${plantName} has been watered.`);
                } else { throw new Error('Server error'); }
            } catch (error) {
                console.error('Error:', error);
                btn.innerHTML = originalContent;
                btn.disabled = false;
                showToast('Error', '😵‍💫 Something went wrong.');
            }
        }
    </script>
</body>
</html>