// Restrict scanning to shipped templates and scripts, never private student code.
const path = require('node:path');
const roots = [
  '*.php', 'app/Views/**/*.php', 'assets/js/**/*.js',
  'AI Project Management/**/*.php', 'AI Project Management/js/*.js',
  'Data Center/**/*.php', 'Data Center/js/*.js',
  'ML Workbench/**/*.php', 'ML Workbench/js/*.js',
  'Model Registry & Deployment/**/*.php', 'Model Registry & Deployment/js/*.js',
  'AI Operations Center (AI SOC)/**/*.php', 'AI Operations Center (AI SOC)/js/*.js'
];
module.exports = roots.map(pattern => path.resolve(__dirname, '..', pattern).replaceAll('\\', '/'));
