<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B.R.U.H. - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style type="text/tailwindcss">
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Space+Grotesk:wght@700;800&display=swap');

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
            --destructive: 0 65% 50%;
            --warning: 30 85% 50%;
            --border: 150 10% 20%;
            --input: 150 10% 20%;
            --ring: 143 35% 48%;
            --font-heading: 'Space Grotesk', sans-serif;
            --font-body: 'Inter', sans-serif;
          }
          
          body {
            @apply bg-background text-foreground;
            font-family: var(--font-body);
          }
          h1, h2, h3 { font-family: var(--font-heading); }
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
                        card: { DEFAULT: "hsl(var(--card))", foreground: "hsl(var(--card-foreground))" },
                        muted: { DEFAULT: "hsl(var(--muted))", foreground: "hsl(var(--muted-foreground))" },
                        destructive: { DEFAULT: "hsl(var(--destructive))" },
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-background flex flex-col items-center justify-center p-4 relative overflow-hidden">

    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary/20 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-primary/10 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="w-full max-w-md bg-card border border-border rounded-2xl shadow-2xl p-8 relative z-10">
        
        <div class="flex flex-col items-center mb-8">
            <div class="h-16 w-16 bg-primary/10 rounded-full flex items-center justify-center mb-4 border border-primary/20">
                <i data-lucide="leaf" class="h-8 w-8 text-primary"></i>
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight text-foreground">B.R.U.H.</h1>
            <p class="text-sm text-muted-foreground mt-2">Botanical Reporting & Unified Habitat-monitor</p>
        </div>

        <?php if (Session::get_flash('error')): ?>
            <div class="mb-6 p-4 rounded-lg bg-destructive/10 border border-destructive/30 flex items-center gap-3 text-destructive font-medium text-sm">
                <i data-lucide="alert-circle" class="h-5 w-5 shrink-0"></i>
                <?= Session::get_flash('error'); ?>
            </div>
        <?php endif; ?>
        <?php if (Session::get_flash('success')): ?>
            <div class="mb-6 p-4 rounded-lg bg-primary/10 border border-primary/30 flex items-center gap-3 text-primary font-medium text-sm">
                <i data-lucide="check-circle-2" class="h-5 w-5 shrink-0"></i>
                <?= Session::get_flash('success'); ?>
            </div>
        <?php endif; ?>

        <form action="/auth/login" method="POST" class="space-y-5">
            <div class="space-y-2">
                <label for="username" class="text-sm font-semibold text-foreground">Username or Email</label>
                <div class="relative">
                    <i data-lucide="user" class="absolute left-3 top-3 h-4 w-4 text-muted-foreground"></i>
                    <input type="text" id="username" name="username" required 
                           class="w-full pl-10 pr-3 py-2 bg-background border border-input rounded-lg text-sm text-foreground focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all placeholder:text-muted-foreground/50" 
                           placeholder="Enter your username" />
                </div>
            </div>

            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <label for="password" class="text-sm font-semibold text-foreground">Password</label>
                </div>
                <div class="relative">
                    <i data-lucide="lock" class="absolute left-3 top-3 h-4 w-4 text-muted-foreground"></i>
                    <input type="password" id="password" name="password" required 
                           class="w-full pl-10 pr-3 py-2 bg-background border border-input rounded-lg text-sm text-foreground focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all placeholder:text-muted-foreground/50" 
                           placeholder="••••••••" />
                </div>
            </div>

            <button type="submit" class="w-full mt-6 bg-primary hover:bg-primary/90 text-primary-foreground font-bold py-2.5 rounded-lg transition-all flex items-center justify-center gap-2 shadow-lg shadow-primary/20">
                Sign In
                <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </button>
        </form>

        <p class="mt-8 text-center text-sm text-muted-foreground">
            Don't have an account? 
            <a href="/auth/register" class="text-primary hover:text-primary/80 font-semibold ml-1 transition-colors">Create one</a>
        </p>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>