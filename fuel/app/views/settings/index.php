<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B.R.U.H. - Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Faculty+Glyphic&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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
          
          body {
            @apply bg-background text-foreground;
            font-family: var(--font-body);
          }

          h1, h2, h3, h4, h5, h6, .font-heading {
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
                <a href="/track" class="flex items-center gap-2 px-3 py-2 rounded-md text-sm font-medium text-muted-foreground hover:text-foreground hover:bg-muted transition-colors">
                    <i data-lucide="clipboard-list" class="h-4 w-4"></i> Track & Manage
                </a>
                <a href="/settings" class="flex items-center gap-2 px-3 py-2 rounded-md text-sm font-medium bg-primary/10 text-primary transition-colors">
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
                <a href="/track" class="block px-4 py-3 rounded-md text-base font-medium text-foreground hover:bg-muted flex items-center gap-3">
                    <i data-lucide="clipboard-list" class="h-5 w-5"></i> Track & Manage
                </a>
                <a href="/settings" class="block px-4 py-3 rounded-md text-base font-bold text-primary bg-primary/10 flex items-center gap-3 pb-4 border-b border-border">
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

    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <div class="mb-8">
            <h1 class="font-extrabold text-3xl text-foreground">Account Settings</h1>
            <p class="text-muted-foreground mt-2">Manage your password and account security here.</p>
        </div>

        <?php if(isset($success_msg)): ?>
            <div class="mb-6 p-4 rounded-md bg-primary/20 border border-primary/50 flex items-center gap-3 text-primary-foreground font-medium">
                <i data-lucide="check-circle-2" class="h-5 w-5"></i>
                <?= $success_msg ?>
            </div>
        <?php endif; ?>
        <?php if(isset($error_msg)): ?>
            <div class="mb-6 p-4 rounded-md bg-destructive/20 border border-destructive/50 flex items-center gap-3 text-destructive-foreground font-medium">
                <i data-lucide="alert-circle" class="h-5 w-5"></i>
                <?= $error_msg ?>
            </div>
        <?php endif; ?>

        <section class="bg-card border border-border rounded-xl shadow-sm mb-8 overflow-hidden">
            <div class="p-6 border-b border-border bg-card/50">
                <h2 class="text-xl font-bold text-card-foreground flex items-center gap-2">
                    <i data-lucide="lock" class="h-5 w-5 text-primary"></i> Change Password
                </h2>
            </div>
            <div class="p-6">
                <form action="/settings/password" method="POST" class="space-y-4">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-foreground" for="old_password">Current Password</label>
                        <input type="password" id="old_password" name="old_password" required class="flex h-10 w-full max-w-md rounded-md border border-input bg-background px-3 py-2 text-sm text-foreground focus:outline-none focus:ring-2 focus:ring-ring shadow-sm" />
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-foreground" for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password" required class="flex h-10 w-full max-w-md rounded-md border border-input bg-background px-3 py-2 text-sm text-foreground focus:outline-none focus:ring-2 focus:ring-ring shadow-sm" />
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-6 py-2 transition-colors">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <section class="bg-card border border-destructive/30 rounded-xl shadow-sm overflow-hidden relative">
            <div class="absolute top-0 left-0 w-1 h-full bg-destructive"></div>
            <div class="p-6 border-b border-border bg-card/50">
                <h2 class="text-xl font-bold text-destructive flex items-center gap-2">
                    <i data-lucide="alert-triangle" class="h-5 w-5"></i> Danger Zone
                </h2>
            </div>
            <div class="p-6">
                <p class="text-sm text-muted-foreground mb-4">
                    Once you delete your account, there is no going back. All your spots, plants, and data will be permanently wiped from our servers. Please be certain.
                </p>
                <form action="/settings/delete" method="POST" onsubmit="return confirm('Are you ABSOLUTELY sure you want to delete your account? This action cannot be undone.');">
                    <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-destructive/10 text-destructive border border-destructive/20 hover:bg-destructive hover:text-destructive-foreground h-10 px-6 py-2 transition-colors">
                        Delete My Account
                    </button>
                </form>
            </div>
        </section>

    </main>

    <script>
        lucide.createIcons();

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
    </script>
</body>
</html>