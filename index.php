<?php
/**
 * index.php – Portfolio Homepage
 * Saiwak Ram | Full Stack Developer
 */

session_start();
require_once 'config/db.php';

// Fetch projects from DB
$db = getDB();
$stmt = $db->query('SELECT * FROM projects ORDER BY created_at DESC');
$projects = $stmt->fetchAll();

// Icons for skills
$skillIcons = [
    'HTML'      => ['bi bi-filetype-html', '#e34f26'],
    'CSS'       => ['bi bi-filetype-css',  '#264de4'],
    'JavaScript'=> ['bi bi-filetype-js',   '#f0db4f'],
    'Bootstrap' => ['bi bi-bootstrap-fill','#7952b3'],
    'PHP'       => ['bi bi-filetype-php',  '#777bb4'],
    'SQL'       => ['bi bi-database-fill', '#00758f'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Saiwak Ram – Full Stack Web Developer specializing in HTML, CSS, JavaScript, Bootstrap, PHP, and SQL. View my portfolio, projects, and contact me.">
    <meta name="keywords" content="Saiwak Ram, Full Stack Developer, PHP Developer, Web Developer, Portfolio, Pakistan">
    <meta name="author" content="Saiwak Ram">
    <meta property="og:title" content="Saiwak Ram | Full Stack Developer">
    <meta property="og:description" content="Professional Full Stack Web Developer – Frontend + Backend + Database Solutions">
    <meta property="og:type" content="website">
    <title>Saiwak Ram | Full Stack Developer</title>

    
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🚀</text></svg>">
</head>
<body>

<!-- ===== PAGE LOADER ===== -->
<div id="page-loader" aria-hidden="true">
    <div class="loader-ring"></div>
</div>

    
<!-- ===== NAVBAR ===== -->
<nav class="navbar navbar-expand-lg fixed-top" id="mainNav" aria-label="Main navigation">
    <div class="container">
        <a class="navbar-brand" href="#hero">SR<span>.</span></a>

        <div class="d-flex align-items-center gap-3 order-lg-last">
            <!-- Theme Toggle -->
            <button id="theme-toggle" aria-label="Toggle dark/light mode" title="Toggle Theme">
            </button>
            <i id="theme-icon" class="bi bi-sun-fill" style="color:var(--text-secondary);font-size:1rem;"></i>
        </div>

        <button class="navbar-toggler border-0 me-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto gap-1">
                <li class="nav-item"><a class="nav-link active" href="#hero">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#skills">Skills</a></li>
                <li class="nav-item"><a class="nav-link" href="#projects">Projects</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="admin/login.php" data-transition>Admin</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- ===== HERO SECTION ===== -->
<section id="hero">
    <!-- Background orbs -->
    <div class="hero-orb hero-orb-1" aria-hidden="true"></div>
    <div class="hero-orb hero-orb-2" aria-hidden="true"></div>

    <!-- Particles container -->
    <div class="hero-particles" aria-hidden="true"></div>

    <div class="container" style="padding-top:var(--navbar-height);">
        <div class="row align-items-center min-vh-100 gy-5">

            <!-- Left: Text Content -->
            <div class="col-lg-6 hero-content">
                <p class="hero-greeting">Hello, World!</p>
                <h1 class="hero-name">Saiwak Ram</h1>

                <div class="hero-typing">
                    <span id="typed-text"></span><span class="typed-cursor">|</span>
                </div>

                <p class="hero-tagline">
                    Full Stack Web Developer | HTML, CSS, JavaScript, Bootstrap, PHP &amp; SQL Expert<br>
                    From <strong style="color:var(--accent)">Design to Database</strong> – Building Fully Functional, Responsive &amp; Dynamic Websites 🚀
                </p>

                <div class="hero-cta">
                    <a href="#contact" class="btn-primary-custom">
                        <i class="bi bi-send"></i> Hire Me
                    </a>
                    <a href="assets/images/saiwak-ram-cv.pdf" class="btn-outline-custom" download>
                        <i class="bi bi-download"></i> Download CV
                    </a>
                </div>

                <!-- Stats -->
                <div class="hero-stats mt-4">
                    <div class="hero-stat">
                        <div class="num counter-num" data-target="4">0</div>
                        <div class="lbl">Projects</div>
                    </div>
                    <div class="hero-stat">
                        <div class="num counter-num" data-target="6">0</div>
                        <div class="lbl">Technologies</div>
                    </div>
                    <div class="hero-stat">
                        <div class="num counter-num" data-target="1">0</div>
                        <div class="lbl">Years Learning</div>
                    </div>
                </div>
            </div>

            <!-- Right: Profile Photo -->
            <div class="col-lg-6 hero-content d-flex justify-content-center">
                <div class="hero-photo-wrapper">
                    <div class="hero-photo-ring">
                        <img src="assets/images/profile.jpg"
                             alt="Saiwak Ram – Full Stack Developer"
                             loading="eager"
                             onerror="this.src='https://ui-avatars.com/api/?name=Saiwak+Ram&size=340&background=6c63ff&color=fff&bold=true&font-size=0.4'">
                    </div>
                    <div class="hero-badge hero-badge-1">
                        <i class="bi bi-code-slash me-1"></i> Full Stack Dev
                    </div>
                    <div class="hero-badge hero-badge-2">
                        <i class="bi bi-shield-check me-1"></i> PHP & SQL Expert
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll indicator -->
    <a class="scroll-indicator" href="#about" aria-label="Scroll down">
        <span>Scroll</span>
        <i class="bi bi-chevron-double-down"></i>
    </a>
</section>

<!-- ===== ABOUT SECTION ===== -->
<section id="about" class="section-pad">
    <div class="container">
        <div class="section-heading reveal">
            <span class="section-tag">About Me</span>
            <h2 class="section-title">Who <span>I Am</span></h2>
            <div class="section-divider"></div>
        </div>

        <div class="row align-items-center gy-5">
            <!-- Image -->
            <div class="col-lg-5 reveal-left">
                <div class="about-img-wrapper">
                    <div class="about-img-frame">
                        <img src="assets/images/profile.jpg"
                             alt="Saiwak Ram"
                             loading="lazy"
                             style="border-radius:var(--radius);"
                             onerror="this.src='https://ui-avatars.com/api/?name=Saiwak+Ram&size=480&background=6c63ff&color=fff&bold=true&font-size=0.35'">
                    </div>
                    <div class="about-img-accent about-img-accent-1" aria-hidden="true"></div>
                    <div class="about-img-accent about-img-accent-2" aria-hidden="true"></div>
                </div>
            </div>

            <!-- Info -->
            <div class="col-lg-7 reveal-right">
                <span class="section-tag mb-3 d-inline-block">Full Stack Developer</span>
                <h3 class="mb-3" style="font-size:1.8rem;font-weight:800;">
                    Building the Web, One Line at a Time
                </h3>
                <p class="about-desc">
                    Hi, I'm <strong>Saiwak Ram</strong> — a passionate Full Stack Web Developer from
                    <strong>Punjab, Pakistan 🇵🇰</strong>. I specialize in crafting modern, responsive,
                    and dynamic web applications using <strong>HTML, CSS, JavaScript, Bootstrap, PHP,
                    and MySQL</strong>.
                </p>
                <p class="about-desc">
                    I enjoy transforming complex ideas into clean, functional, and visually impressive
                    digital experiences — from designing pixel-perfect frontends to building robust
                    backend systems and database architectures. My goal is always to deliver complete,
                    production-ready solutions that stand out.
                </p>

                <!-- Info Grid -->
                <div class="about-info-grid">
                    <div class="about-info-item">
                        <i class="bi bi-person-fill"></i>
                        <div>
                            <div class="info-label">Full Name</div>
                            <div class="info-val">Saiwak Ram</div>
                        </div>
                    </div>
                    <div class="about-info-item">
                        <i class="bi bi-geo-alt-fill"></i>
                        <div>
                            <div class="info-label">Location</div>
                            <div class="info-val">Punjab, Pakistan</div>
                        </div>
                    </div>
                    <div class="about-info-item">
                        <i class="bi bi-mortarboard-fill"></i>
                        <div>
                            <div class="info-label">Education</div>
                            <div class="info-val">Intermediate (2025)</div>
                        </div>
                    </div>
                    <div class="about-info-item">
                        <i class="bi bi-envelope-fill"></i>
                        <div>
                            <div class="info-label">Email</div>
                            <div class="info-val" style="font-size:.8rem;">saiwakram786pur@gmail.com</div>
                        </div>
                    </div>
                    <div class="about-info-item">
                        <i class="bi bi-telephone-fill"></i>
                        <div>
                            <div class="info-label">Phone</div>
                            <div class="info-val">03188280472</div>
                        </div>
                    </div>
                    <div class="about-info-item">
                        <i class="bi bi-briefcase-fill"></i>
                        <div>
                            <div class="info-label">Status</div>
                            <div class="info-val" style="color:var(--accent-3);">Available for Hire</div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3 flex-wrap">
                    <a href="#contact" class="btn-primary-custom">
                        <i class="bi bi-chat-dots"></i> Let's Talk
                    </a>
                    <a href="https://github.com/saiwakram" target="_blank" rel="noopener noreferrer" class="btn-outline-custom">
                        <i class="bi bi-github"></i> GitHub
                    </a>
                </div>
            </div>
        </div>
    </div>
    
</section>

<!-- ===== SKILLS SECTION ===== -->
<section id="skills" class="section-pad">
    <div class="container">
        <div class="section-heading reveal">
            <span class="section-tag">My Skills</span>
            <h2 class="section-title">Technical <span>Expertise</span></h2>
            <div class="section-divider"></div>
        </div>

        <div class="row gy-5">
            <!-- Skill Bars -->
            <div class="col-lg-6 reveal-left">
                <div class="p-4 bg-glass rounded-custom">
                    <div class="skill-category-title"><i class="bi bi-code-slash me-2"></i>Proficiency</div>

                    <?php
                    $skills = [
                        ['HTML',        92, '#e34f26'],
                        ['CSS',         88, '#264de4'],
                        ['JavaScript',  78, '#f0db4f'],
                        ['Bootstrap 5', 90, '#7952b3'],
                        ['PHP',         82, '#777bb4'],
                        ['MySQL / SQL', 80, '#00758f'],
                    ];
                    foreach ($skills as [$name, $pct, $color]) : ?>
                    <div class="skill-item">
                        <div class="skill-header">
                            <span class="skill-name"><?= htmlspecialchars($name) ?></span>
                            <span class="skill-pct"><?= $pct ?>%</span>
                        </div>
                        <div class="skill-bar">
                            <div class="skill-fill" data-pct="<?= $pct ?>"
                                 style="background:linear-gradient(90deg,<?= $color ?>99,<?= $color ?>);"></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Skill Icon Cards -->
            <div class="col-lg-6 reveal-right">
                <div class="row g-3">
                    <?php
                    $skillCards = [
                        ['bi bi-filetype-html', '#e34f26', 'HTML5',       'Structure & Semantics'],
                        ['bi bi-filetype-css',  '#264de4', 'CSS3',         'Styling & Animations'],
                        ['bi bi-filetype-js',   '#f0db4f', 'JavaScript',   'Dynamic Interactions'],
                        ['bi bi-bootstrap-fill','#7952b3', 'Bootstrap 5',  'Responsive Grid'],
                        ['bi bi-filetype-php',  '#777bb4', 'PHP',          'Server-Side Logic'],
                        ['bi bi-database-fill', '#00758f', 'MySQL',        'Database Design'],
                        ['bi bi-layout-text-sidebar-reverse','#6c63ff','Frontend','UI/UX Development'],
                        ['bi bi-server',        '#ff6584', 'Backend',      'API & Architecture'],
                    ];
                    foreach ($skillCards as [$icon, $color, $title, $sub]) : ?>
                    <div class="col-6 col-sm-4 col-lg-3">
                        <div class="skill-icon-card reveal-scale">
                            <i class="<?= $icon ?>" style="color:<?= $color ?>;"></i>
                            <div class="skill-lbl"><?= $title ?></div>
                            <div style="font-size:.72rem;color:var(--text-secondary);margin-top:4px;"><?= $sub ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== PROJECTS SECTION ===== -->
<section id="projects" class="section-pad">
    <div class="container">
        <div class="section-heading reveal">
            <span class="section-tag">My Work</span>
            <h2 class="section-title">Featured <span>Projects</span></h2>
            <div class="section-divider"></div>
        </div>

        <?php if (empty($projects)) : ?>
            <div class="text-center text-secondary py-5">
                <i class="bi bi-folder-x" style="font-size:3rem;display:block;margin-bottom:12px;color:var(--accent-2);"></i>
                No projects yet. <a href="admin/login.php" style="color:var(--accent);">Add from Admin Panel</a>
            </div>
        <?php else : ?>
        <div class="row g-4">
            <?php
            // Project icons mapping
            $projectIcons = [
                'Transport ERP'       => ['bi bi-truck', 'var(--gradient-1)'],
                'Job Portal'          => ['bi bi-briefcase', 'var(--gradient-2)'],
                'Portfolio Website'   => ['bi bi-person-bounding-box', 'var(--gradient-3)'],
                'Medical Store System'=> ['bi bi-capsule', 'linear-gradient(135deg,#f093fb,#f5576c)'],
            ];
            foreach ($projects as $project) :
                $tags = array_map('trim', explode(',', $project['technologies']));
                $icon = $projectIcons[$project['title']] ?? ['bi bi-code-square', 'var(--gradient-1)'];
            ?>
            <div class="col-md-6 col-xl-3 reveal">
                <div class="project-card">
                    <!-- Image / Placeholder -->
                    <div class="project-img">
                        <?php if (!empty($project['image']) && file_exists('assets/images/' . $project['image'])) : ?>
                            <img src="assets/images/<?= htmlspecialchars($project['image']) ?>"
                                 alt="<?= htmlspecialchars($project['title']) ?>"
                                 loading="lazy">
                        <?php else : ?>
                            <div class="project-img-placeholder" style="background:<?= $icon[1] ?>">
                                <i class="<?= $icon[0] ?>"></i>
                            </div>
                        <?php endif; ?>

                        <!-- Overlay -->
                        <div class="project-overlay">
                            <?php if (!empty($project['github_link'])) : ?>
                            <a href="<?= htmlspecialchars($project['github_link']) ?>"
                               target="_blank" rel="noopener noreferrer"
                               class="project-github-link"
                               aria-label="View <?= htmlspecialchars($project['title']) ?> on GitHub">
                                <i class="bi bi-github"></i>
                            </a>
                            <?php endif; ?>
                            <a href="#" class="project-preview-btn" aria-label="Quick preview">
                                <i class="bi bi-eye"></i>
                            </a>
                            <?php if (!empty($project['demo_link'])) : ?>
                            <a href="<?= htmlspecialchars($project['demo_link']) ?>"
                               target="_blank" rel="noopener noreferrer"
                               aria-label="Live demo">
                                <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="project-body">
                        <h3 class="project-title"><?= htmlspecialchars($project['title']) ?></h3>
                        <p class="project-desc"><?= htmlspecialchars($project['description']) ?></p>
                        <div class="project-tags">
                            <?php foreach ($tags as $tag) : ?>
                                <span class="project-tag"><?= htmlspecialchars($tag) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ===== CONTACT SECTION ===== -->
<section id="contact" class="section-pad">
    <div class="container">
        <div class="section-heading reveal">
            <span class="section-tag">Get In Touch</span>
            <h2 class="section-title">Contact <span>Me</span></h2>
            <div class="section-divider"></div>
        </div>

        <div class="row gy-4">
            <!-- Contact Info -->
            <div class="col-lg-4 reveal-left">
                <div class="contact-info-card">
                    <h4 style="font-weight:800;margin-bottom:8px;">Let's Work Together!</h4>
                    <p style="color:var(--text-secondary);font-size:.88rem;margin-bottom:24px;">
                        Have a project in mind? I'd love to hear about it. Reach out and let's build something great.
                    </p>

                    <div class="contact-item">
                        <div class="contact-item-icon"><i class="bi bi-envelope-fill"></i></div>
                        <div>
                            <div class="contact-item-label">Email</div>
                            <div class="contact-item-val">
                                <a href="mailto:saiwakram786pur@gmail.com">saiwakram786pur@gmail.com</a>
                            </div>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-item-icon" style="background:var(--gradient-2);"><i class="bi bi-telephone-fill"></i></div>
                        <div>
                            <div class="contact-item-label">Phone</div>
                            <div class="contact-item-val">
                                <a href="tel:+923188280472">+92 318 8280472</a>
                            </div>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-item-icon" style="background:var(--gradient-3);"><i class="bi bi-geo-alt-fill"></i></div>
                        <div>
                            <div class="contact-item-label">Location</div>
                            <div class="contact-item-val">Punjab, Pakistan</div>
                        </div>
                    </div>

                    <!-- Social Links -->
                    <div class="social-links">
                        <a href="https://github.com/saiwakram" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="GitHub">
                            <i class="bi bi-github"></i>
                        </a>
                        <a href="mailto:saiwakram786pur@gmail.com" class="social-link" aria-label="Email">
                            <i class="bi bi-envelope-fill"></i>
                        </a>
                        <a href="tel:+923188280472" class="social-link" aria-label="Phone">
                            <i class="bi bi-telephone-fill"></i>
                        </a>
                        <a href="https://wa.me/923188280472" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="WhatsApp" style="color:#25d366;">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-8 reveal-right">
                <div class="contact-form-card">
                    <h4 style="font-weight:800;margin-bottom:6px;">Send a Message</h4>
                    <p style="color:var(--text-secondary);font-size:.88rem;margin-bottom:24px;">
                        Fill in the form below and I'll get back to you as soon as possible.
                    </p>

                    <form id="contact-form" novalidate>
                        <div class="row g-3">
                            <div class="col-sm-6 form-group">
                                <label class="form-label-custom" for="contact-name">Full Name</label>
                                <input type="text" id="contact-name" name="name"
                                       class="form-control-custom"
                                       placeholder="Your name" maxlength="100">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label-custom" for="contact-email">Email Address</label>
                                <input type="email" id="contact-email" name="email"
                                       class="form-control-custom"
                                       placeholder="your@email.com" maxlength="150">
                            </div>
                            <div class="col-12 form-group">
                                <label class="form-label-custom" for="contact-subject">Subject</label>
                                <input type="text" id="contact-subject" name="subject"
                                       class="form-control-custom"
                                       placeholder="What's this about?" maxlength="200">
                            </div>
                            <div class="col-12 form-group">
                                <label class="form-label-custom" for="contact-message">Message</label>
                                <textarea id="contact-message" name="message"
                                          class="form-control-custom"
                                          rows="5"
                                          placeholder="Tell me about your project…"></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn-primary-custom w-100 justify-content-center">
                                    <i class="bi bi-send"></i> Send Message
                                </button>
                                <div class="form-msg" role="alert"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== PROJECT MODAL ===== -->
<div class="modal fade" id="projectModal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-glass" style="border:1px solid var(--glass-border);border-radius:var(--radius);">
            <div class="modal-header" style="border-bottom:1px solid var(--glass-border);">
                <h5 class="modal-title fw-bold" id="modal-title">Project Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding:28px;">
                <p id="modal-desc" style="color:var(--text-secondary);line-height:1.8;"></p>
                <div class="mt-3">
                    <strong style="font-size:.8rem;text-transform:uppercase;letter-spacing:.08em;color:var(--accent);">Technologies</strong>
                    <p id="modal-tags" style="font-size:.88rem;margin-top:6px;color:var(--text-secondary);"></p>
                </div>
            </div>
            <div class="modal-footer" style="border-top:1px solid var(--glass-border);">
                <a href="#" id="modal-github" target="_blank" rel="noopener noreferrer" class="btn-primary-custom">
                    <i class="bi bi-github"></i> View on GitHub
                </a>
                <button class="btn-outline-custom" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ===== FOOTER ===== -->
<footer class="footer">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-4">
                <div class="footer-brand">SR<span style="-webkit-text-fill-color:var(--accent-2);">.</span></div>
                <p class="footer-desc">
                    Full Stack Web Developer crafting modern, responsive, and dynamic web applications.
                    Let's build something amazing together.
                </p>
                <div class="social-links mt-3">
                    <a href="https://github.com/saiwakram" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="GitHub"><i class="bi bi-github"></i></a>
                    <a href="mailto:saiwakram786pur@gmail.com" class="social-link" aria-label="Email"><i class="bi bi-envelope-fill"></i></a>
                    <a href="https://wa.me/923188280472" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    <a href="tel:+923188280472" class="social-link" aria-label="Phone"><i class="bi bi-telephone-fill"></i></a>
                </div>
            </div>
            <div class="col-lg-2 offset-lg-2 footer-links">
                <h6>Quick Links</h6>
                <ul>
                    <li><a href="#hero">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#skills">Skills</a></li>
                    <li><a href="#projects">Projects</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-2 footer-links">
                <h6>Projects</h6>
                <ul>
                    <li><a href="#projects">Transport ERP</a></li>
                    <li><a href="#projects">Job Portal</a></li>
                    <li><a href="#projects">Portfolio</a></li>
                    <li><a href="#projects">Medical Store</a></li>
                </ul>
            </div>
            <div class="col-lg-2 footer-links">
                <h6>Technology</h6>
                <ul>
                    <li><a href="#skills">HTML & CSS</a></li>
                    <li><a href="#skills">JavaScript</a></li>
                    <li><a href="#skills">PHP</a></li>
                    <li><a href="#skills">MySQL</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>
                &copy; <?= date('Y') ?> <strong>Saiwak Ram</strong>. All rights reserved. 
                Crafted with <span style="color:var(--accent-2);">❤</span> using PHP, Bootstrap 5 &amp; JavaScript.
            </p>
        </div>
    </div>
</footer>

<!-- ===== BACK TO TOP ===== -->
<button id="back-to-top" aria-label="Back to top">
    <i class="bi bi-chevron-up"></i>
</button>

<!-- ===== TOAST ===== -->
<div id="toast" role="status" aria-live="polite"></div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="assets/js/script.js"></script>
</body>
</html>

