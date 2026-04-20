<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B.R.U.H. - Track & Manage</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Faculty+Glyphic&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style type="text/tailwindcss">
        @import url('https://fonts.googleapis.com/css2?family=Faculty+Glyphic&family=Inter:wght@400;500;600;700;800&display=swap');

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

      h1, h2, h3, h4, button.font-heading, span.font-heading {
        font-family: var(--font-heading);
        letter-spacing: -0.01em;
      }
    }
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
                <span class="font-extrabold text-xl tracking-tight text-foreground font-heading">B.R.U.H.</span>
            </div>
            <div class="hidden md:flex items-center gap-1">
                <a href="/dashboard" class="flex items-center gap-2 px-3 py-2 rounded-md text-sm font-medium text-muted-foreground hover:text-foreground hover:bg-muted transition-colors">
                    <i data-lucide="layout-dashboard" class="h-4 w-4"></i> Dashboard
                </a>
                <a href="/track" class="flex items-center gap-2 px-3 py-2 rounded-md text-sm font-medium bg-primary/10 text-primary transition-colors">
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
                <a href="/auth/logout" class="text-sm font-medium text-destructive hover:opacity-80 transition-colors flex items-center gap-1.5">
                    <i data-lucide="log-out" class="h-4 w-4"></i> <span class="font-bold">Logout</span>
                </a>
            </div>
            <button onclick="toggleMobileMenu()" class="md:hidden p-2 text-muted-foreground hover:text-foreground rounded-md transition-colors focus:outline-none">
                <i data-lucide="menu" id="menu-icon" class="h-6 w-6"></i>
            </button>
        </div>

        <div id="mobile-menu" class="hidden absolute top-16 left-0 w-full bg-card border-b border-border shadow-2xl md:hidden">
            <div class="px-4 pt-2 pb-6 space-y-2">
                <a href="/dashboard" class="block px-4 py-3 rounded-md text-base font-medium text-foreground hover:bg-muted flex items-center gap-3">
                    <i data-lucide="layout-dashboard" class="h-5 w-5"></i> Dashboard
                </a>
                <a href="/track" class="block px-4 py-3 rounded-md text-base font-bold text-primary bg-primary/10 flex items-center gap-3">
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
        
        <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h1 class="font-extrabold text-2xl text-foreground">Track & Manage</h1>
            <div class="flex gap-2">
                <button onclick="openModal('addSpotModal')" class="inline-flex items-center justify-center rounded-md text-sm font-medium border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 transition-colors">
                    <i data-lucide="plus" class="h-4 w-4 mr-2"></i> Add Spot
                </button>
                <?php if(!empty($spots)): ?>
                <button onclick="openModal('addPlantModal')" class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 transition-colors">
                    <i data-lucide="leaf" class="h-4 w-4 mr-2"></i> Add Plant
                </button>
                <?php endif; ?>
            </div>
        </div>

        <section class="mb-10">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-bold text-xl text-foreground">Spot Management</h2>
            </div>
            <div class="flex flex-col gap-2">
                <?php if(empty($spots)): ?>
                    <div class="bg-card border border-border rounded-lg p-8 text-center text-muted-foreground">
                        <i data-lucide="map-pin" class="h-8 w-8 mx-auto mb-3 opacity-50"></i>
                        <p class="text-sm">No spots found. Click "Add Spot" above to create one!</p>
                    </div>
                <?php else: ?>
                    <?php foreach($spots as $spot): ?>
                    <?php 
                        $plant_count = 0;
                        foreach($plants as $p) { if($p->spot_id == $spot->id) $plant_count++; }
                    ?>
                    <div class="bg-card border border-border rounded-lg px-4 py-3 flex items-center justify-between gap-4 shadow-sm hover:border-muted-foreground/30 transition-colors">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="h-8 w-8 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="map-pin" class="h-4 w-4 text-primary"></i>
                            </div>
                            <span class="font-bold text-card-foreground truncate"><?= $spot->name ?></span>
                            <span class="text-xs text-muted-foreground whitespace-nowrap">〒<?= $spot->display_postal_code() ?></span>
                            <span class="inline-flex items-center rounded-full bg-secondary px-2.5 py-0.5 text-xs font-semibold text-secondary-foreground border border-border">
                                <?= $plant_count ?> plants
                            </span>
                        </div>
                        <div class="flex gap-1 flex-shrink-0">
                            <button onclick="openEditSpotModal(<?= $spot->id ?>, '<?= addslashes($spot->name) ?>', '<?= addslashes($spot->postal_code) ?>')" class="text-muted-foreground hover:text-foreground p-1.5 rounded-md hover:bg-muted transition-colors">
                                <i data-lucide="pencil" class="h-4 w-4"></i>
                            </button>
                            <form action="/spot/delete/<?= $spot->id ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this spot?');">
                                <button type="submit" class="text-muted-foreground hover:text-destructive p-2 rounded-md hover:bg-destructive/10 transition-colors">
                                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <section>
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-bold text-xl text-foreground">Plant Management</h2>
            </div>
            
            <?php if(empty($plants)): ?>
                <div class="bg-card border border-border rounded-lg p-8 text-center text-muted-foreground">
                    <i data-lucide="sprout" class="h-8 w-8 mx-auto mb-3 opacity-50"></i>
                    <p class="text-sm">No plants found. Click "Add Plant" above to add one!</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php foreach($plants as $plant): ?>
                    <?php 
                        $latest_date_ymd = null;
                        $is_last_updated_stale = false;
                        if(!empty($plant->growth_logs)) {
                            $logs = $plant->growth_logs;
                            usort($logs, function($a, $b) { return $b->measured_at - $a->measured_at; });
                            $latest_ts = (int)$logs[0]->measured_at;
                            $latest_date_ymd = date('Y/m/d', $latest_ts);
                            $is_last_updated_stale = (time() - $latest_ts) >= (30 * 24 * 60 * 60);
                        }
                    ?>
                    <div class="bg-card border border-border rounded-xl p-5 shadow-sm hover:border-primary/50 transition-all flex flex-col h-full">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="sprout" class="h-5 w-5 text-primary"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="font-bold text-card-foreground leading-tight"><?= $plant->name ?></h3>
                                    </div>
                                    <p class="text-xs text-muted-foreground"><?= $plant->species ?></p>
                                </div>
                            </div>
                            <div class="flex gap-1">
                                <button onclick="openEditPlantModal(<?= $plant->id ?>, '<?= addslashes($plant->name) ?>', '<?= addslashes($plant->species) ?>', '<?= addslashes($plant->size) ?>', '<?= addslashes($plant->pot_size) ?>', <?= $plant->spot_id ?>)" class="text-muted-foreground hover:text-foreground p-1.5 rounded-md hover:bg-muted transition-colors">
                                    <i data-lucide="pencil" class="h-4 w-4"></i>
                                </button>
                                <form action="/plant/delete/<?= $plant->id ?>" method="POST" class="inline" onsubmit="return confirm('Delete this plant?');">
                                    <button type="submit" class="text-muted-foreground hover:text-destructive p-1.5 rounded-md hover:bg-destructive/10 transition-colors">
                                        <i data-lucide="trash-2" class="h-4 w-4"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-2 mb-4 mt-2">
                            <span class="inline-flex items-center rounded-full bg-secondary px-2.5 py-0.5 text-xs font-semibold text-secondary-foreground border border-border">
                                <span class="text-muted-foreground font-normal mr-1">Size:</span> <?= $plant->size ?>
                            </span>
                            <span class="inline-flex items-center rounded-full bg-secondary px-2.5 py-0.5 text-xs font-semibold text-secondary-foreground border border-border">
                                <span class="text-muted-foreground font-normal mr-1">Pot:</span> <?= $plant->pot_size ?>
                            </span>
                        </div>

                        <div class="mt-auto pt-4 border-t border-border">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-[10px] font-bold text-muted-foreground uppercase tracking-wider flex items-center gap-1.5">
                                        <i data-lucide="trending-up" class="h-3.5 w-3.5 text-primary"></i>
                                        GROWTH ANALYTICS
                                    </h4>
                                    <p class="text-[10px] mt-1 <?= $is_last_updated_stale ? 'text-destructive' : 'text-muted-foreground' ?>">
                                        Last updated: <?= $latest_date_ymd ?: '-' ?>
                                    </p>
                                </div>
                                <?php if(!empty($plant->growth_logs)): ?>
                                    <button onclick="toggleGrowthView(<?= $plant->id ?>)" class="text-muted-foreground hover:text-primary focus:outline-none p-1 rounded transition-colors">
                                        <i data-lucide="chevron-down" id="chevron-<?= $plant->id ?>" class="h-5 w-5 transition-transform duration-300"></i>
                                    </button>
                                <?php endif; ?>
                            </div>

                            <?php if(empty($plant->growth_logs)): ?>
                                <p class="text-[10px] text-muted-foreground italic py-2 mt-2">No history recorded yet.</p>
                            <?php else: ?>
                                <div id="growth-chart-container-<?= $plant->id ?>" class="hidden w-full h-[120px] mt-4">
                                    <div id="growth-chart-<?= $plant->id ?>"></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <div id="addSpotModal" class="hidden fixed inset-0 z-50 bg-background/80 flex items-center justify-center p-4 backdrop-blur-sm transition-opacity">
        <div class="bg-card border border-border rounded-xl shadow-xl w-full max-w-md overflow-hidden">
            <form action="/spot/create" method="POST">
                <div class="flex flex-col space-y-1.5 p-6 border-b border-border">
                    <h2 class="text-lg font-bold text-card-foreground">Add New Spot</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-foreground">Spot Name</label>
                        <input name="name" required placeholder="e.g. Kitchen Window" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm text-foreground focus:outline-none focus:ring-2 focus:ring-ring shadow-sm" />
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-foreground">Postal Code</label>
                        <input name="postal_code" placeholder="e.g. 100-0001" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm text-foreground focus:outline-none focus:ring-2 focus:ring-ring shadow-sm" />
                    </div>
                </div>
                <div class="flex items-center justify-end p-6 border-t border-border gap-3">
                    <button type="button" onclick="closeModal('addSpotModal')" class="inline-flex items-center justify-center rounded-md text-sm font-medium border border-input bg-background text-foreground hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">Cancel</button>
                    <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">Add Spot</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editSpotModal" class="hidden fixed inset-0 z-50 bg-background/80 flex items-center justify-center p-4 backdrop-blur-sm transition-opacity">
        <div class="bg-card border border-border rounded-xl shadow-xl w-full max-w-md overflow-hidden">
            <form id="editSpotForm" action="" method="POST">
                <div class="flex flex-col space-y-1.5 p-6 border-b border-border">
                    <h2 class="text-lg font-bold text-card-foreground">Edit Spot</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-foreground">Spot Name</label>
                        <input id="edit-spot-name" name="name" required class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm text-foreground focus:outline-none focus:ring-2 focus:ring-ring shadow-sm" />
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-foreground">Postal Code</label>
                        <input id="edit-spot-postal" name="postal_code" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm text-foreground focus:outline-none focus:ring-2 focus:ring-ring shadow-sm" />
                    </div>
                </div>
                <div class="flex items-center justify-end p-6 border-t border-border gap-3">
                    <button type="button" onclick="closeModal('editSpotModal')" class="inline-flex items-center justify-center rounded-md text-sm font-medium border border-input bg-background text-foreground hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">Cancel</button>
                    <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <div id="addPlantModal" class="hidden fixed inset-0 z-50 bg-background/80 flex items-center justify-center p-4 backdrop-blur-sm transition-opacity">
        <div class="bg-card border border-border rounded-xl shadow-xl w-full max-w-md overflow-hidden">
            <form action="/plant/create" method="POST">
                <div class="flex flex-col space-y-1.5 p-6 border-b border-border">
                    <h2 class="text-lg font-bold text-card-foreground">Add New Plant</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-foreground">Assign to Spot</label>
                        <select name="spot_id" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm text-foreground focus:outline-none focus:ring-2 focus:ring-ring shadow-sm">
                            <?php foreach($spots as $spot): ?>
                                <option value="<?= $spot->id ?>"><?= $spot->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-foreground">Plant Name</label>
                        <input name="name" required placeholder="e.g. Sir Fern-a-lot" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm text-foreground focus:outline-none focus:ring-2 focus:ring-ring shadow-sm" />
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-foreground">Species</label>
                        <input name="species" placeholder="e.g. Boston Fern" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm text-foreground focus:outline-none focus:ring-2 focus:ring-ring shadow-sm" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-foreground">Size</label>
                            <input name="size" placeholder="e.g. 30cm" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm text-foreground focus:outline-none focus:ring-2 focus:ring-ring shadow-sm" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-foreground">Pot Number</label>
                            <input name="pot_size" placeholder="e.g. No. 5" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm text-foreground focus:outline-none focus:ring-2 focus:ring-ring shadow-sm" />
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end p-6 border-t border-border gap-3">
                    <button type="button" onclick="closeModal('addPlantModal')" class="inline-flex items-center justify-center rounded-md text-sm font-medium border border-input bg-background text-foreground hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">Cancel</button>
                    <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">Add Plant</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editPlantModal" class="hidden fixed inset-0 z-50 bg-background/80 flex items-center justify-center p-4 backdrop-blur-sm transition-opacity">
        <div class="bg-card border border-border rounded-xl shadow-xl w-full max-w-md overflow-hidden">
            <form id="editPlantForm" action="" method="POST">
                <div class="flex flex-col space-y-1.5 p-6 border-b border-border">
                    <h2 class="text-lg font-bold text-card-foreground">Edit Plant</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-foreground">Assign to Spot</label>
                        <select id="edit-plant-spot" name="spot_id" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm text-foreground focus:outline-none focus:ring-2 focus:ring-ring shadow-sm">
                            <?php foreach($spots as $spot): ?>
                                <option value="<?= $spot->id ?>"><?= $spot->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-foreground">Plant Name</label>
                        <input id="edit-plant-name" name="name" required class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm text-foreground focus:outline-none focus:ring-2 focus:ring-ring shadow-sm" />
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-foreground">Species</label>
                        <input id="edit-plant-species" name="species" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm text-foreground focus:outline-none focus:ring-2 focus:ring-ring shadow-sm" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-foreground">Size</label>
                            <input id="edit-plant-size" name="size" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm text-foreground focus:outline-none focus:ring-2 focus:ring-ring shadow-sm" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-foreground">Pot Number</label>
                            <input id="edit-plant-pot" name="pot_size" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm text-foreground focus:outline-none focus:ring-2 focus:ring-ring shadow-sm" />
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end p-6 border-t border-border gap-3">
                    <button type="button" onclick="closeModal('editPlantModal')" class="inline-flex items-center justify-center rounded-md text-sm font-medium border border-input bg-background text-foreground hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">Cancel</button>
                    <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <?php
        $chart_data = [];
        foreach($plants as $p) {
            $log_data = [];
            if(!empty($p->growth_logs)) {
                foreach($p->growth_logs as $l) {
                    preg_match('/[\d\.]+/', $l->height, $matches);
                    $val = !empty($matches[0]) ? (float)$matches[0] : 0;
                    $log_data[] = ['x' => date('Y-m-d', $l->measured_at), 'y' => $val];
                }
                usort($log_data, function($a, $b) { return strtotime($a['x']) - strtotime($b['x']); });
            }
            $chart_data[] = ['id' => $p->id, 'data' => $log_data];
        }
    ?>

    <script>
        lucide.createIcons();

        function openModal(modalId) { document.getElementById(modalId).classList.remove('hidden'); }
        function closeModal(modalId) { document.getElementById(modalId).classList.add('hidden'); }
        function openEditSpotModal(id, name, postal_code) {
            document.getElementById('editSpotForm').action = '/spot/update/' + id;
            document.getElementById('edit-spot-name').value = name;
            document.getElementById('edit-spot-postal').value = postal_code;
            document.getElementById('editSpotModal').classList.remove('hidden');
        }
        function openEditPlantModal(id, name, species, size, pot_size, spot_id) {
            document.getElementById('editPlantForm').action = '/plant/update/' + id;
            document.getElementById('edit-plant-name').value = name;
            document.getElementById('edit-plant-species').value = species;
            document.getElementById('edit-plant-size').value = size;
            document.getElementById('edit-plant-pot').value = pot_size;
            document.getElementById('edit-plant-spot').value = spot_id;
            document.getElementById('editPlantModal').classList.remove('hidden');
        }

        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const icon = document.getElementById('menu-icon');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                icon.setAttribute('data-lucide', 'x');
            } else {
                menu.classList.add('hidden');
                icon.setAttribute('data-lucide', 'menu');
            }
            lucide.createIcons();
        }

        const plantGrowthData = <?= json_encode($chart_data) ?>;
        const renderedCharts = {};

        function toggleGrowthView(plantId) {
            const chartCont = document.getElementById(`growth-chart-container-${plantId}`);
            const chevron = document.getElementById(`chevron-${plantId}`);
            
            if (chartCont.classList.contains('hidden')) {
                chartCont.classList.remove('hidden');
                chevron.style.transform = 'rotate(180deg)'; 
                
                if (!renderedCharts[plantId]) {
                    renderGrowthChart(plantId);
                    renderedCharts[plantId] = true;
                }
            } else {
                chartCont.classList.add('hidden');
                chevron.style.transform = 'rotate(0deg)'; 
            }
        }

        function renderGrowthChart(plantId) {
            const plantInfo = plantGrowthData.find(p => p.id == plantId);
            if (!plantInfo || plantInfo.data.length === 0) return;

            const options = {
                series: [{ name: 'Size', data: plantInfo.data.map(d => d.y) }],
                chart: { 
                    type: 'area', 
                    height: 120, 
                    parentHeightOffset: 0,
                    toolbar: { show: false },
                    sparkline: { enabled: true },
                    fontFamily: 'Inter, sans-serif'
                },
                grid: {
                    show: true,
                    borderColor: 'rgba(255,255,255,0.05)',
                    strokeDashArray: 4,
                    xaxis: { lines: { show: true } },
                    yaxis: { lines: { show: false } },
                    padding: { top: 0, right: 20, bottom: 0, left: 20 }
                },
                colors: ['#4ade80'],
                stroke: { curve: 'smooth', width: 2 },
                fill: {
                    type: 'gradient',
                    gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0, stops: [0, 100] }
                },
                tooltip: {
                    theme: 'dark',
                    fixed: { enabled: false },
                    x: { show: true, formatter: (val, opts) => plantInfo.data[opts.dataPointIndex].x },
                    y: { title: { formatter: () => '' } },
                    marker: { show: false }
                },
                markers: { size: 3, colors: ['#4ade80'], strokeWidth: 0, hover: { size: 5 } }
            };

            const chart = new ApexCharts(document.querySelector(`#growth-chart-${plantId}`), options);
            chart.render();
        }
    </script>
</body>
</html>